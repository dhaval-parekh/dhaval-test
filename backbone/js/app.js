var Theater = {
	Models: {},
	Collections: {},
	Views: {},
	Templates: {}
}
//	Movies Modal
Theater.Models.Movie = Backbone.Model.extend({});
//	Movies Collection
Theater.Collections.Movies = Backbone.Collection.extend({
	model: Theater.Models.Movie,
	url: 'data/movies.json',
	initialize: function () {
		console.log("Movies initialize")
	}
})
//	Movies View
Theater.Templates.movies = _.template($("#tmplt-Movies").html())
Theater.Views.Movies = Backbone.View.extend({
	el: $('#mainContainer'),
	template: Theater.Templates.movies,
	initialize: function () {
		//_.bindAll(this, "render", "addOne", "addAll");
		this.collection.bind("reset", this.render, this);
		this.collection.bind("add", this.addOne, this);
	},
	render: function () {
		console.log("render movies")
		console.log(this.collection.length);
		$(this.el).html(this.template());
		this.addAll();
	},
	addAll: function () {
		console.log("addAll")
		this.collection.each(this.addOne);
	},
	addOne: function (model) {
		console.log("addOne")
		view = new Theater.Views.Movie({model: model});
		$("ul", this.el).append(view.render());
	},
});

// Movie part 
Theater.Templates.movie = _.template($("#tmplt-Movie").html());
Theater.Views.Movie = Backbone.View.extend({
	tagName: "li",
	template: Theater.Templates.movie,
	//events: { "click .delete": "test" },

	initialize: function () {
		//_.bindAll(this, 'render', 'test');
		this.model.bind('destroy', this.destroyItem, this);
		this.model.bind('remove', this.removeItem, this);
	},
	render: function () {
		console.log('movie render');
		return $(this.el).append(this.template(this.model.toJSON()));
	},
	removeItem: function (model) {
		console.log("Remove - " + model.get("Name"))
		this.remove();
	}
});

Theater.Router = Backbone.Router.extend({
	routes: {
		'': 'defaultRoute',
	},
	defaultRoute: function () {
		console.log("defaultRoute");
		Theater.movies = new Theater.Collections.Movies();
		new Theater.Views.Movies({
			collection: Theater.movies,
		})
		Theater.movies.fetch();
	}
});
var appRouter = new Theater.Router();
Backbone.history.start();