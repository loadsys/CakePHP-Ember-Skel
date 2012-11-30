App = Ember.Application.create();

App.store = DS.Store.create({
	revision: 9,
	adapter: DS.RESTAdapter.create({
		// url: 'http://api.something.com',
		namespace: 'api',
		bulkCommit: false
	})
});