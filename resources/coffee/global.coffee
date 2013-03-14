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

    ###
        Replace the dynamic form fields on type change
    ###
    onRepositoryTypeChange = ->
        $this = $(@)
        $target = $this.parents('.repository:first').find('[data-behavior="dynamic-fields"]')
        index   = $this.attr('name').replace(/^config\[repositories\]\[(\d+)\]\[type\]$/g, '$1')
        type    = $this.val()

        $target.load($this.data('route').replace(/__type__/g, type).replace(/__index__/g, index))

    ###
        Launch an Ajax request to trigger config build
    ###
    triggerBuild = (e) ->
        e.preventDefault()
        $this = $(@)
        $this.addClass('disabled loading')
        $.post($this.attr('href'), -> $this.removeClass('disabled loading'))

    $ ->
        $('#homepage-heading')
            .on('click', '[data-behavior=build-button]', triggerBuild)

        $('#config-form')
            .on('click', '[data-behavior=remove-repository]', removeRepository)
            .on('click', '[data-behavior=add-repository]', addRepository)
            .on('change','[data-behavior=repository-type]', onRepositoryTypeChange)
            .find('.repository input')
                .each(parseRepositoryIndex)

)(jQuery)
