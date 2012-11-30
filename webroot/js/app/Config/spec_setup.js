App = Ember.Namespace.create();

App.store = DS.Store.create({
	revision: 9,
	adapter: DS.fixtureAdapter
});