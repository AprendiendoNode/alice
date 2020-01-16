/*
@license

dhtmlxGantt v.6.3.4 Standard

This version of dhtmlxGantt is distributed under GPL 2.0 license and can be legally used in GPL projects.

To use dhtmlxGantt in non-GPL projects (and get Pro version of the product), please obtain Commercial/Enterprise or Ultimate license on our site https://dhtmlx.com/docs/products/dhtmlxGantt/#licensing or contact us at sales@dhtmlx.com

(c) XB Software Ltd.

*/
!function(t,n){"object"==typeof exports&&"object"==typeof module?module.exports=n():"function"==typeof define&&define.amd?define("ext/dhtmlxgantt_undo",[],n):"object"==typeof exports?exports["ext/dhtmlxgantt_undo"]=n():t["ext/dhtmlxgantt_undo"]=n()}(window,function(){return function(t){var n={};function e(o){if(n[o])return n[o].exports;var a=n[o]={i:o,l:!1,exports:{}};return t[o].call(a.exports,a,a.exports,e),a.l=!0,a.exports}return e.m=t,e.c=n,e.d=function(t,n,o){e.o(t,n)||Object.defineProperty(t,n,{enumerable:!0,get:o})},e.r=function(t){"undefined"!=typeof Symbol&&Symbol.toStringTag&&Object.defineProperty(t,Symbol.toStringTag,{value:"Module"}),Object.defineProperty(t,"__esModule",{value:!0})},e.t=function(t,n){if(1&n&&(t=e(t)),8&n)return t;if(4&n&&"object"==typeof t&&t&&t.__esModule)return t;var o=Object.create(null);if(e.r(o),Object.defineProperty(o,"default",{enumerable:!0,value:t}),2&n&&"string"!=typeof t)for(var a in t)e.d(o,a,function(n){return t[n]}.bind(null,a));return o},e.n=function(t){var n=t&&t.__esModule?function(){return t.default}:function(){return t};return e.d(n,"a",n),n},e.o=function(t,n){return Object.prototype.hasOwnProperty.call(t,n)},e.p="/codebase/",e(e.s=220)}({218:function(t,n,e){"use strict";Object.defineProperty(n,"__esModule",{value:!0});var o=10,a=function(){function t(){var t=this;this.maxSteps=o,this.undoEnabled=!0,this.redoEnabled=!0,this.action={create:function(t){return{commands:t?t.slice():[]}},invert:function(n){for(var e,o=gantt.copy(n),a=t.command,i=0;i<n.commands.length;i++){var s=o.commands[i]=a.invert(o.commands[i]);s.type!==a.type.update&&s.type!==a.type.move||(e=[s.oldValue,s.value],s.value=e[0],s.oldValue=e[1])}return o}},this.command={entity:null,type:null,create:function(t,n,e,o){return{entity:o,type:e,value:gantt.copy(t),oldValue:gantt.copy(n||t)}},invert:function(t){var n=gantt.copy(t);return n.type=this.inverseCommands(t.type),n},inverseCommands:function(t){switch(t){case this.type.update:return this.type.update;case this.type.remove:return this.type.add;case this.type.add:return this.type.remove;case this.type.move:return this.type.move;default:return gantt.assert(!1,"Invalid command "+t),null}}},this._undoStack=[],this._redoStack=[]}return t.prototype.getUndoStack=function(){return this._undoStack},t.prototype.getRedoStack=function(){return this._redoStack},t.prototype.clearUndoStack=function(){this._undoStack=[]},t.prototype.clearRedoStack=function(){this._redoStack=[]},t.prototype.updateConfigs=function(){this.maxSteps=gantt.config.undo_steps||o,this.command.entity=gantt.config.undo_types,this.command.type=gantt.config.undo_actions,this.undoEnabled=!!gantt.config.undo,this.redoEnabled=!!gantt.config.undo&&!!gantt.config.redo},t.prototype.undo=function(){if(this.updateConfigs(),this.undoEnabled){var t=this._pop(this._undoStack);if(t&&this._reorderCommands(t),!1!==gantt.callEvent("onBeforeUndo",[t])&&t)return this._applyAction(this.action.invert(t)),this._push(this._redoStack,gantt.copy(t)),void gantt.callEvent("onAfterUndo",[t]);gantt.callEvent("onAfterUndo",[null])}},t.prototype.redo=function(){if(this.updateConfigs(),this.redoEnabled){var t=this._pop(this._redoStack);if(t&&this._reorderCommands(t),!1!==gantt.callEvent("onBeforeRedo",[t])&&t)return this._applyAction(t),this._push(this._undoStack,gantt.copy(t)),void gantt.callEvent("onAfterRedo",[t]);gantt.callEvent("onAfterRedo",[null])}},t.prototype.logAction=function(t){this._push(this._undoStack,t),this._redoStack=[]},t.prototype._push=function(t,n){if(n.commands.length){var e=t===this._undoStack?"onBeforeUndoStack":"onBeforeRedoStack";if(!1!==gantt.callEvent(e,[n])&&n.commands.length){for(t.push(n);t.length>this.maxSteps;)t.shift();return n}}},t.prototype._pop=function(t){return t.pop()},t.prototype._reorderCommands=function(t){var n={any:0,link:1,task:2},e={move:1,any:0};t.commands.sort(function(t,o){if("task"===t.entity&&"task"===o.entity)return t.type!==o.type?(e[o.type]||0)-(e[t.type]||0):"move"===t.type&&t.oldValue&&o.oldValue&&o.oldValue.parent===t.oldValue.parent?t.oldValue.$index-o.oldValue.$index:0;var a=n[t.entity]||n.any;return(n[o.entity]||n.any)-a})},t.prototype._applyAction=function(t){var n=null,e=this.command.entity,o=this.command.type,a={};a[e.task]={add:"addTask",get:"getTask",update:"updateTask",remove:"deleteTask",move:"moveTask",isExists:"isTaskExists"},a[e.link]={add:"addLink",get:"getLink",update:"updateLink",remove:"deleteLink",isExists:"isLinkExists"},gantt.batchUpdate(function(){for(var e=0;e<t.commands.length;e++){n=t.commands[e];var i=a[n.entity][n.type],s=a[n.entity].get,r=a[n.entity].isExists;if(n.type===o.add)gantt[i](n.oldValue,n.oldValue.parent,n.oldValue.$index);else if(n.type===o.remove)gantt[r](n.value.id)&&gantt[i](n.value.id);else if(n.type===o.update){var d=gantt[s](n.value.id);for(var c in n.value)c.startsWith("$")||c.startsWith("_")||(d[c]=n.value[c]);gantt[i](n.value.id)}else n.type===o.move&&gantt[i](n.value.id,n.value.$index,n.value.parent)}})},t}();n.Undo=a},219:function(t,n,e){"use strict";Object.defineProperty(n,"__esModule",{value:!0});var o={onBeforeUndo:"onAfterUndo",onBeforeRedo:"onAfterRedo"},a=["onTaskDragStart","onAfterTaskUpdate","onAfterTaskDelete","onBeforeBatchUpdate"],i=function(){function t(t){this._batchAction=null,this._batchMode=!1,this._ignore=!1,this._ignoreMoveEvents=!1,this._initialTasks={},this._initialLinks={},this._nestedTasks={},this._nestedLinks={},this._undo=t,this._attachEvents()}return t.prototype.store=function(t,n,e){return void 0===e&&(e=!1),n===gantt.config.undo_types.task?this._storeTask(t,e):n===gantt.config.undo_types.link&&this._storeLink(t,e)},t.prototype.isMoveEventsIgnored=function(){return this._ignoreMoveEvents},t.prototype.toggleIgnoreMoveEvents=function(t){this._ignoreMoveEvents=t||!1},t.prototype.startIgnore=function(){this._ignore=!0},t.prototype.stopIgnore=function(){this._ignore=!1},t.prototype.startBatchAction=function(){var t=this;this._timeout&&clearTimeout(this._timeout),this._timeout=setTimeout(function(){t.stopBatchAction()},10),this._ignore||this._batchMode||(this._batchMode=!0,this._batchAction=this._undo.action.create())},t.prototype.stopBatchAction=function(){if(!this._ignore){var t=this._undo;this._batchAction&&t.logAction(this._batchAction),this._batchMode=!1,this._batchAction=null}},t.prototype.onTaskAdded=function(t){this._ignore||this._storeTaskCommand(t,this._undo.command.type.add)},t.prototype.onTaskUpdated=function(t){this._ignore||this._storeTaskCommand(t,this._undo.command.type.update)},t.prototype.onTaskMoved=function(t){this._ignore||this._storeEntityCommand(t,this.getInitialTask(t.id),this._undo.command.type.move,this._undo.command.entity.task)},t.prototype.onTaskDeleted=function(t){if(!this._ignore){if(this._storeTaskCommand(t,this._undo.command.type.remove),this._nestedTasks[t.id])for(var n=this._nestedTasks[t.id],e=0;e<n.length;e++)this._storeTaskCommand(n[e],this._undo.command.type.remove);if(this._nestedLinks[t.id]){var o=this._nestedLinks[t.id];for(e=0;e<o.length;e++)this._storeLinkCommand(o[e],this._undo.command.type.remove)}}},t.prototype.onLinkAdded=function(t){this._ignore||this._storeLinkCommand(t,this._undo.command.type.add)},t.prototype.onLinkUpdated=function(t){this._ignore||this._storeLinkCommand(t,this._undo.command.type.update)},t.prototype.onLinkDeleted=function(t){this._ignore||this._storeLinkCommand(t,this._undo.command.type.remove)},t.prototype.setNestedTasks=function(t,n){for(var e=null,o=[],a=this._getLinks(gantt.getTask(t)),i=0;i<n.length;i++)e=this.setInitialTask(n[i]),a=a.concat(this._getLinks(e)),o.push(e);var s={};for(i=0;i<a.length;i++)s[a[i]]=!0;var r=[];for(var i in s)r.push(this.setInitialLink(i));this._nestedTasks[t]=o,this._nestedLinks[t]=r},t.prototype.setInitialTask=function(t,n){if(n||!this._initialTasks[t]||!this._batchMode){var e=gantt.copy(gantt.getTask(t));e.$index=gantt.getTaskIndex(t),this.setInitialTaskObject(t,e)}return this._initialTasks[t]},t.prototype.getInitialTask=function(t){return this._initialTasks[t]},t.prototype.clearInitialTasks=function(){this._initialTasks={}},t.prototype.setInitialTaskObject=function(t,n){this._initialTasks[t]=n},t.prototype.setInitialLink=function(t,n){return this._initialLinks[t]&&this._batchMode||(this._initialLinks[t]=gantt.copy(gantt.getLink(t))),this._initialLinks[t]},t.prototype.getInitialLink=function(t){return this._initialLinks[t]},t.prototype.clearInitialLinks=function(){this._initialLinks={}},t.prototype._attachEvents=function(){var t=this,n=null,e=function(){n||(n=setTimeout(function(){n=null}),t.clearInitialTasks(),gantt.eachTask(function(n){t.setInitialTask(n.id)}),t.clearInitialLinks(),gantt.getLinks().forEach(function(n){t.setInitialLink(n.id)}))},i=function(t){return gantt.copy(gantt.getTask(t))};for(var s in o)gantt.attachEvent(s,function(){return t.startIgnore(),!0}),gantt.attachEvent(o[s],function(){return t.stopIgnore(),!0});for(s=0;s<a.length;s++)gantt.attachEvent(a[s],function(){return t.startBatchAction(),!0});gantt.attachEvent("onParse",function(){t._undo.clearUndoStack(),t._undo.clearRedoStack(),e()}),gantt.attachEvent("onAfterTaskAdd",function(n,e){t.setInitialTask(n,!0),t.onTaskAdded(e)}),gantt.attachEvent("onAfterTaskUpdate",function(n,e){t.onTaskUpdated(e)}),gantt.attachEvent("onAfterTaskDelete",function(n,e){t.onTaskDeleted(e)}),gantt.attachEvent("onAfterLinkAdd",function(n,e){t.setInitialLink(n,!0),t.onLinkAdded(e)}),gantt.attachEvent("onAfterLinkUpdate",function(n,e){t.onLinkUpdated(e)}),gantt.attachEvent("onAfterLinkDelete",function(n,e){t.onLinkDeleted(e)}),gantt.attachEvent("onRowDragEnd",function(n,e){return t.onTaskMoved(i(n)),t.toggleIgnoreMoveEvents(),!0}),gantt.attachEvent("onBeforeTaskDelete",function(n){t.store(n,gantt.config.undo_types.task);var o=[];return e(),gantt.eachTask(function(t){o.push(t.id)},n),t.setNestedTasks(n,o),!0});var r=gantt.getDatastore("task");r.attachEvent("onBeforeItemMove",function(n,o,a){return t.isMoveEventsIgnored()||e(),!0}),r.attachEvent("onAfterItemMove",function(n,e,o){return t.isMoveEventsIgnored()||t.onTaskMoved(i(n)),!0}),gantt.attachEvent("onRowDragStart",function(n,o,a){return t.toggleIgnoreMoveEvents(!0),e(),!0}),gantt.attachEvent("onBeforeTaskDrag",function(n){return t.store(n,gantt.config.undo_types.task)}),gantt.attachEvent("onLightbox",function(n){return t.store(n,gantt.config.undo_types.task)}),gantt.attachEvent("onBeforeTaskAutoSchedule",function(n){return t.store(n.id,gantt.config.undo_types.task),!0}),gantt.ext.inlineEditors&&gantt.ext.inlineEditors.attachEvent("onEditStart",function(n){t.store(n.id,gantt.config.undo_types.task)})},t.prototype._storeCommand=function(t){var n=this._undo;if(n.updateConfigs(),n.undoEnabled)if(this._batchMode)this._batchAction.commands.push(t);else{var e=n.action.create([t]);n.logAction(e)}},t.prototype._storeEntityCommand=function(t,n,e,o){var a=this._undo.command.create(t,n,e,o);this._storeCommand(a)},t.prototype._storeTaskCommand=function(t,n){this._storeEntityCommand(t,this.getInitialTask(t.id),n,this._undo.command.entity.task)},t.prototype._storeLinkCommand=function(t,n){this._storeEntityCommand(t,this.getInitialLink(t.id),n,this._undo.command.entity.link)},t.prototype._getLinks=function(t){return t.$source.concat(t.$target)},t.prototype._storeTask=function(t,n){var e=this;return void 0===n&&(n=!1),this.setInitialTask(t,n),gantt.eachTask(function(t){e.setInitialTask(t.id)},t),!0},t.prototype._storeLink=function(t,n){return void 0===n&&(n=!1),this.setInitialLink(t,n),!0},t}();n.Monitor=i},220:function(t,n,e){"use strict";Object.defineProperty(n,"__esModule",{value:!0});var o=e(219),a=new(e(218).Undo),i=new o.Monitor(a);function s(t,n,e){t&&(t.id===n&&(t.id=e),t.parent===n&&(t.parent=e))}function r(t,n,e){s(t.value,n,e),s(t.oldValue,n,e)}function d(t,n,e){t&&(t.source===n&&(t.source=e),t.target===n&&(t.target=e))}function c(t,n,e){d(t.value,n,e),d(t.oldValue,n,e)}function u(t,n,e){for(var o=a,i=0;i<t.length;i++)for(var s=t[i],d=0;d<s.commands.length;d++)s.commands[d].entity===o.command.entity.task?r(s.commands[d],n,e):s.commands[d].entity===o.command.entity.link&&c(s.commands[d],n,e)}function l(t,n,e){for(var o=a,i=0;i<t.length;i++)for(var s=t[i],r=0;r<s.commands.length;r++){var d=s.commands[r];d.entity===o.command.entity.link&&(d.value&&d.value.id===n&&(d.value.id=e),d.oldValue&&d.oldValue.id===n&&(d.oldValue.id=e))}}gantt.config.undo=!0,gantt.config.redo=!0,gantt.config.undo_types={link:"link",task:"task"},gantt.config.undo_actions={update:"update",remove:"remove",add:"add",move:"move"},gantt.ext||(gantt.ext={}),gantt.ext.undo={undo:function(){return a.undo()},redo:function(){return a.redo()},getUndoStack:function(){return a.getUndoStack()},getRedoStack:function(){return a.getRedoStack()},clearUndoStack:function(){return a.clearUndoStack()},clearRedoStack:function(){return a.clearRedoStack()},saveState:function(t,n){return i.store(t,n,!0)}},gantt.undo=gantt.ext.undo.undo,gantt.redo=gantt.ext.undo.redo,gantt.getUndoStack=gantt.ext.undo.getUndoStack,gantt.getRedoStack=gantt.ext.undo.getRedoStack,gantt.clearUndoStack=gantt.ext.undo.clearUndoStack,gantt.clearRedoStack=gantt.ext.undo.clearRedoStack,gantt.attachEvent("onTaskIdChange",function(t,n){var e=a;u(e.getUndoStack(),t,n),u(e.getRedoStack(),t,n)}),gantt.attachEvent("onLinkIdChange",function(t,n){var e=a;l(e.getUndoStack(),t,n),l(e.getRedoStack(),t,n)}),gantt.attachEvent("onGanttReady",function(){a.updateConfigs()})}})});
//# sourceMappingURL=dhtmlxgantt_undo.js.map