Handlebars.registerHelper('if_eq', function(a, b, opts) {
  if (a == b)
    return opts.fn(this);
  else
    return opts.inverse(this);
});
Handlebars.registerHelper('eq', function (value1, value2, options) {
  if (value1 === value2) {
      return true;
  } else {
      return false;
  }
});