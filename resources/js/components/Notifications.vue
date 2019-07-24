<template>
  <li class="nav-item dropdown mr-1">
    <a class="nav-link count-indicator dropdown-toggle d-flex justify-content-center align-items-center" id="messageDropdown" href="#" data-toggle="dropdown" >
      <i class="mdi mdi-message-text mx-0"></i>
      <span class="count" v-if="notifications.length > 0" style="color: white; background-color: #f39c12 !important; font-size: 9px;"></span>
      <span class="count" v-else-if="notifications.length <= 0" style="color: white; background-color: #aab2bd; !important; font-size: 9px;"></span>
    </a>


    <div class="dropdown-menu dropdown-menu-right navbar-dropdown" aria-labelledby="messageDropdown" style="max-height: 50vh; overflow: auto;">
      <p class="mb-0 font-weight-normal float-left dropdown-header" v-if="notifications.length > 0">Notificaciones: {{ notifications.length }}</p>
      <p class="mb-0 font-weight-normal float-left dropdown-header" v-else-if="notifications.length <= 0">Sin notificaciones de viáticos</p>

      <div v-for="notification in notifications">
        <a class="dropdown-item" v-bind:href="notification.data.link" v-if="notification.type ==  notification_a" >
          <div class="item-thumbnail">
            <img src="/img/website/user.jpg" alt="image" class="profile-pic">
          </div>
          <div class="item-content flex-grow">
            <h6 class="ellipsis font-weight-normal">Folio: {{ notification.data.folio }}
            </h6>
            <p class="font-weight-light small-text text-muted mb-0"> Estatus:  {{ notification.data.status }}</p>
            <p class="font-weight-light small-text text-muted text-right mb-0">  {{ notification.data.created_at }} </p>
          </div>
        </a>
        <a class="dropdown-item" v-else >

        </a>
      </div>


    </div>


  </li>
</template>

<script>
    export default {
        data(){
          return {
            key: "",
            notification_a: "App\\Notifications\\MessageViatic",
            'notifications': [],
            interval: null
          }
        },
        mounted() {
          this.interval = setInterval(function () {
            axios.get('../notificaciones').then(res => {
              this.notifications = res.data;
            });
          }.bind(this), 3000);
        },
        beforeDestroy: function(){
           clearInterval(this.interval);
       }
    }
</script>
