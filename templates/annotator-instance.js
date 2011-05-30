jQuery(function ($) {
  var element= $('{{annotator_content}}');
  var storeConfig = {
    prefix: 'http://annotateit.org/api'
  };
  var annotationData = {
    uri: '{{uri}}',
    account_id: '{{account_id}}'
  },
  authConfig = {
  },
  loadFromSearch = {
    uri: '{{uri}}'
  };
  element.data('annotator:headers', {'x-annotator-user-id': 'afiore'});

{{#load_limit}}
  loadFromSearch.limit = {{load_limit}};
{{/load_limit}}

  if (element) {

    storeConfig.annotationData = annotationData;
    storeConfig.loadFromSearch = loadFromSearch;

    element.annotator()
           .annotator('addPlugin','Store', storeConfig)
           .annotator('addPlugin','Tags')
           .annotator('addPlugin','Permissions');

    element.data('annotator').plugins['Permissions'].setUser("afiore");

  } else {
    throw new Error("OkfnAnnotator: Unable to find a DOM element for selector {{annotator_content}}; cannot instantiate the Annotator");
  }

});
