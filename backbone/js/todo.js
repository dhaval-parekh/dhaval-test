$(function () {

	var Books = Backbone.Collection.extend({
		url: '/books'
	});
	console.log(Books);
});