App = Ember.Application.create();

App.Store = DS.Store.extend({
	revision: 11,
	adapter: DS.RESTAdapter.create({
		// url: 'http://api.something.com',
		namespace: 'api',
		bulkCommit: false
	})
});
