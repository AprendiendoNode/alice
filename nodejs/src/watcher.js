const mysql = require('mysql');
const MySQLEvents = require('@rodrigogs/mysql-events');

const connection = mysql.createConnection({
  host: 'localhost',
  user: 'root',
  password: '532100',
});

const instance = new MySQLEvents(connection, { //Instanciamos y creamos la conexión a la base de datos
  startAtEnd: true, //Empezar a escuchar eventos después del método start()
  excludedSchemas: { //Tablas a excluir
    mysql: true,
  },
});

instance.start()
  .then(() => console.log('Mysql watcher running!'))
  .catch(err => console.error('Something bad happened!', err));

instance.addTrigger({
  name: 'TEST',
  expression: '*',
  statement: MySQLEvents.STATEMENTS.ALL,
  onEvent: (event) => { // You will receive the events here
    console.log(event);
  },
});

instance.on(MySQLEvents.EVENTS.CONNECTION_ERROR, console.error);
instance.on(MySQLEvents.EVENTS.ZONGJI_ERROR, console.error);

//OFFICIAL getDocumentation
//https://github.com/rodrigogs/mysql-events
