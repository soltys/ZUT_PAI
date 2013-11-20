(function(){
var TODOS = [{ id: 1, name: 'pozmywaj'},
{id: 2, name: 'uprasuj koszule'},
{id: 3, name: 'zrób obiad'}];
can.fixture('DELETE /todo_projekt/todos/{id}', function(){
return {};
});
can.fixture('PUT /todos/{id}', function(request){
$.extend( TODOS[ (+request.data.id)-1 ], request.data );
return {};
});
can.fixture('POST /todos', function(request){
var id = TODOS.length + 1;
TODOS.push( $.extend({id: id}, request.data) );
return {id: id};
});
can.fixture('GET /todos', function(){
return TODOS;
});
can.fixture('GET /todos/{id}', function(request){
return TODOS[(+request.data.id)-1];
});
})();

var Todo = can.Model({
findAll : 'GET /todos',
findOne : 'GET /todos/{id}',
create : 'POST /todos',
update : 'PUT /todos/{id}',
destroy : 'DELETE /todos/{id}'
} , {});

var Todos = can.Control({
defaults: {
view: 'todos.ejs'
}
},
{
init: function( element, options ){
Todo.findAll( {}, function( todos ) {
element.html( can.view(options.view , todos) );
});
},
"li click" : function( li , event ){
var todo = li.data('todo');
li.trigger('selected', todo);
},

"li .destroy click": function( el, event ){
var todo = el.closest('li').data('todo');
el.closest('li').remove();
//todo.destroy();

event.stopPropagation();
}
});
var todosControl = new Todos("#todos");

Todo.findAll( {}, function( todos ) {
var frag = can.view('todos.ejs', todos)
$("#todos").html( frag );
window.todos = todos;
});



var Editor = can.Control({
todo: function( todo) {
this.options.todo = todo;
this.on();
this.setName();
this.element.show();
},
setName: function() {
this.element.val( this.options.todo.name )
},
"change": function() {
var todo = this.options.todo;
todos.push(new Todo({name: this.element.val()}));
this.element.val("");
//todo.save()
},
"{todo} destroyed": function() {
this.element.hide();
}
})
var editorControl = new Editor("#editor");
$("#todos").bind("selected", function( ev , todo ){
editorControl.todo( todo );
})