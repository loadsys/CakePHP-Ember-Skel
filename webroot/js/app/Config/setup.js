App = Ember.Application.create();

App.store = DS.Store.create({
	revision: 11,
	adapter: DS.RESTAdapter.create({
		// url: 'http://api.something.com',
		namespace: 'api',
		bulkCommit: false
	})
});
