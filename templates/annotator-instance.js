jQuery(function ($) {
  var element= $('{{annotator_content}}'),
      authToken = '{{auth_token}}',
      accountId = '{{account_id}}',
      uri = '{{uri}}',
      userId = '{{user_id}}',
      userName = '{{user_name}}',

      storeConfig = {
        prefix: 'http://annotateit.org/api'
      },
      userConfig = {
        id: userId,
        name: (userName && userName.length) ? userName : null
      },
      annotationData = {
        uri: uri,
        accountId: accountId
      },
      userDisplayName = userName,
      loadFromSearch = {
        uri: uri
      };

  element.data('annotator:headers', {
    'x-annotator-user-id': userId,
    'x-annotator-auth-token': authToken,
    'x-annotator-account-id': accountId
  });


{{#load_limit}}
  loadFromSearch.limit = {{load_limit}};
{{/load_limit}}


  if (element) {

    storeConfig.annotationData = annotationData;
    storeConfig.loadFromSearch = loadFromSearch;


    element.annotator()
           .annotator('addPlugin','Store', storeConfig)
           .annotator('addPlugin','Tags')
           .annotator('addPlugin','Permissions', {
             'user': userConfig,
             'userAuthorize': function (user, token) {
               return user.id === token;
             },
             'userString': function (user) {
               if (user && user.name) {
                 return user.name;
               }

               return user.id;
             },

             // todo: implement groups and allow admins 
             // to delete annotations
             'permissions': {
               'read': [],
               'update': [userId],
               'delete': [userId],
               'admin':  [userId]
             }
           });


  } else {
    throw new Error("OkfnAnnotator: Unable to find a DOM element for selector '{{annotator_content}}'; cannot instantiate the Annotator");
  }

});
