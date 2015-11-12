(function($){
	Backbone.emulateJSON = false;
	Backbone.emulateHTTP = false;

	var UrlPackageModel = Backbone.Model.extend({
	    defaults: {
	        url: ''
	    },
	    url:'/core/add'
	});

	var AppView = Backbone.View.extend({
		el: '.app',
		model: new UrlPackageModel,
		events: {
			'keyup input.url': 'handleKeyEvent',
			'submit': 'submit'
		},

	    initialize: function(){
	      //console.log($('input.url'))
	    },
	    
	    handleKeyEvent: function(e) {
	    	var self = this;

	    	if(e.keyCode == 13) {
	    		var params = {
	    			url: self.$el.find("#url").val()
	    		};
	       		$.post( '/core/add', params, function( data ) {
	       			
					self.$el.find('#result p').html('Your URL has been shortened to <i><a href="' + data.url + '" target="_blank">' + data.url + '</a></i>').parent().show();
					 
					 //UIkit.notify('Your URL has been shortened!');
				});
		  	}
	    },
	    submit: function (e) {
	    	e.preventDefault();
	    }
	});

	$(document).ready(function() {
		var appView = new AppView();
	});
 	
})(jQuery);