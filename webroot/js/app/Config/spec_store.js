App.set('rootElement', '#ember-app');
App.store = DS.Store.create({
	revision: 9,
	adapter: DS.fixtureAdapter
});

