(($) ->

    repositoryIndex = 0

    ###
        Parse all repository collection input names to find
        the last collection index.
    ###
    parseRepositoryIndex = ->
        index = parseInt($(@).attr('name').match(/^config\[repositories\]\[(\d+)\]/)[1])
        repositoryIndex = Math.max(index + 1, repositoryIndex)

    ###
        Remove a repository from the repository collection
    ###
    removeRepository = ->
        $(@).parents('[data-behavior=repository]').remove()

    ###
        Adds a repository to the repository colelction
    ###
    addRepository = ->
        $('[data-behavior=new-repositories]').append($(@).data('prototype').replace(/__name__/g, repositoryIndex++))

    $ ->
        $('#config-form')
            .on('click', '[data-behavior=remove-repository]', removeRepository)
            .on('click', '[data-behavior=add-repository]', addRepository)
            .find('.repository input')
                .each(parseRepositoryIndex)

)(jQuery)
