(($) ->

    removeRepository = ->
        $(@).parents('[data-behavior=repository]').remove()

    addRepository = ->
        $('[data-behavior=new-repositories]').append($(@).data('prototype'))

    $ ->
        $('#config-form')
            .on('click', '[data-behavior=remove-repository]', removeRepository)
            .on('click', '[data-behavior=add-repository]', addRepository)

)(jQuery)
