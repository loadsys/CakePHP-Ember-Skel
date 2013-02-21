var hbs, content, data
  , fs = require('fs')
  , args = process.argv.slice(2);

if (args.length !== 2) return;

hbs = require(args[0]);
data = fs.readFileSync(args[1], 'utf8');
content = 'Ember.Handlebars.compile('+hbs.precompile(data.trimRight())+')';
process.stdout.write(content);

