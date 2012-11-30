App.ApplicationRoute = Ember.Route.extend({
	route: '/',

	connectOutlets: function(router) {
		// This first connectOutlets will get called but the route won't be set up
		// yet. Ember.run.next runs the code after control returns to Ember.
		Ember.run.next(function() {
			router.get('applicationController').connectOutlet('navBar', 'navBar');
		});
	},

	index: Ember.Route.extend({
		route: '/',

		enter: function(router) {
			router.get('navBarController').set('currentState', null);
		},

		connectOutlets: function(router) {
			router.get('applicationController').connectOutlet('home');
		}
	}),

	// Branches
	contacts: App.ContactsRoute.extend(),
	groups: App.GroupsRoute.extend(),

	// Actions
	goToHome: Ember.Router.transitionTo('root.index'),
	goToContacts: Ember.Router.transitionTo('contacts.index'),
	goToGroups: Ember.Router.transitionTo('groups.index'),

	showContact: Ember.Router.transitionTo('contacts.show'),
	showGroup: Ember.Router.transitionTo('groups.show')
});