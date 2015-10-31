jQuery(function ($) {
    var element = $('{{annotator_content}}');

    if (element) {
        var annotatorInstance = element.annotator();
        annotatorInstance
            .annotator('setupPlugins', null, {
                Store: {
                    annotationData: {uri: '{{uri}}'},
                    loadFromSearch: {uri: '{{uri}}', limit: 200}
                },
                Permissions: {
                    user: '{{user}}',
                },
                Auth: {
                    token: '{{token}}'
                }
            })
    } else {
        throw new Error("OkfnAnnotator: Unable to find a DOM element for selector '{{annotator_content}}'; cannot instantiate the Annotator");
    }

});
