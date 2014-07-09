jQuery(document).ready(function($){

});

//hold press enter event
function enter(e) {
    if (e.keyCode == 13) {
        $(".sub").trigger('click');
        return false;
    }
}

//Get Translation

function getTranslation()
{
    var data={
        'suppress' : $('#translate').data('translate-suppress'),
        'cancel' : $('#translate').data('translate-cancel'),
        'tag_add' : $('#translate').data('translate-tag-add'),
        'media_add' : $('#translate').data('translate-media-add'),
        'render_add' : $('#translate').data('translate-render-add'),
        'project_choose' : $('#translate').data('translate-project-choose'),
        'yes' : $('#translate').data('translate-yes'),
        'project_notdeleted' : $('#translate').data('translate-project-notdeleted'),
        'book_add' : $('#translate').data('translate-book-add'),
        'book_delete' : $('#translate').data('translate-book-delete'),
        'noresult' : $('#translate').data('translate-noresult')
    };
    return data;
}

//get the height of thumbnail

function equalHeight(group) {
    tallest = 0;
    group.each(function() {
        thisHeight = $(this).height();
        thisImg = $(this).find('.img');
        thisImgHeight= thisImg.find('.media-object').height();
        // thisImg.width(320);
        if(thisImg.parent().width() < 330) {
          thisImg.css('width', '100%');
        }
        if(thisHeight > tallest) {
            // if (thisHeight > 450) {
            //     thisHeight=450;
            // };
            tallest = thisHeight;
        }
        if(thisImgHeight > 320){
        console.log(thisImgHeight);
        //   $(this).find('.img').css('height',thisImgHeight);
        // } else{
        //   $(this).find('.img').css('height', '320');
        }
    });
    group.each(function() { $(this).height(tallest); });
}


// Add the form of a collection
function addForm(collectionHolder, $newLinkLi) {
    var prototype = collectionHolder.attr('data-prototype');

    var newForm = prototype.replace(/__name__/g, collectionHolder.children().length);

    var $newFormLi = $('<li class="input"></li>').append(newForm);
    $newLinkLi.before($newFormLi);
    addFormDeleteLink($newFormLi);
    $($newFormLi).find('.providerSelector').change(function(){
        var valueSelected=$('option:selected', this).text();
        var input=$(this).parent().parent().children(':first-child').children('.providerInput');
        if (valueSelected == "Dailymotion" || valueSelected == "Youtube" || valueSelected == "Vimeo") {
            $(input).attr('type', 'text');
        }
        if (valueSelected == "File" || valueSelected == "Image") {
            $(input).attr('type', 'file');
        }
    });
    $($newFormLi).find('.mediaSelector').change(function(){
      var valueSelected=$('option:selected', this).text();
      var input =$(this).parent().parent().find(".providerInput");
      var selector =$(this).parent().parent().find(".providerSelector");
      if(valueSelected == translate['media_add'])
      {
        input.show();
        selector.show();
      }else{
        input.hide();
        selector.hide();
      }
    });
    $($newFormLi).find('.renderSelector').change(function(){
      var valueSelected=$('option:selected', this).text();
      var input =$(this).parent().parent().find(".providerInput");
      var selector =$(this).parent().parent().find(".providerSelector");
      if(valueSelected == translate['render_add'])
      {
        input.show();
        selector.show();
      }else{
        input.hide();
        selector.hide();
      }
    });
    if (typeof(availableTags) != 'undefined') {
        $( ".tagInput").autocomplete({
      source: availableTags,
      messages: {
        noResults: '',
        results: function() {}
    }
    });
    }

}

//add a delete link on each form

function addFormDeleteLink($MediaFormLi)
{
    var $removeFormA = $('<a href="#"><span class="glyphicon glyphicon-remove"></span></a>');
    $MediaFormLi.append($removeFormA);
    $removeFormA.on('click', function(e) {
        e.preventDefault();
        $MediaFormLi.remove();
    });
}

$(document).ready(function () {
    equalHeight($(".thumbnail"));

    // Manage tags collection

    var collectionTagsHolder = $('ul.tags');
    var $addTagLink = $('<a href="#" class="add_tag_link">'+translate['tag_add']+'</a>');
    var $newLinkLiTag = $('<ul></ul>').append($addTagLink);

    //Manage Medias collection

    var collectionMediasHolder = $('ul.medias');
    var $addMediaLink = $('<a href="#" class="add_media_link">'+translate['media_add']+'</a>');
    var $newLinkLiMedia = $('<ul></ul>').append($addMediaLink);

    //Manage Renders collection

    var collectionRendersHolder = $('ul.renders');
    var $addRenderLink = $('<a href="#" class="add_render_link">'+translate['render_add']+'</a>');
    var $newLinkLiRender = $('<ul></ul>').append($addRenderLink);

    //Manage Project collection

    var collectionProjectsHolder = $('ul.projects');
    var $addProjectLink = $('<a href="#" class="add_project_link">'+translate['project_choose']+'</a>');
    var $newLinkLiProject = $('<ul></ul>').append($addProjectLink);



    //fancybox is a js plugin to have an apercu of an image
    $(".fancybox").fancybox({
        helpers: {
            title : {
                type : 'hover'
            }
        }
    });
    $("#single_1").fancybox({
        helpers: {
            title : {
                type : 'hover'
            }
        }
    });
  //Action to delete project/book
    $('.btn-remove').on('click',function () {
        var self = $(this);
        var id = $(this).data('id');
        var title = $(this).data('title');
        var url = $(this).data('url');

        //set messages
        noty({

            text        : translate['suppress']+' : "'+title+'" ?',
            type        : self.data('type'),
            dismissQueue: true,
            layout      : self.data('layout'),
            buttons     : [
                {addClass: 'btn btn-primary', text: translate['yes'], onClick: function ($noty) {
                    $noty.close();
                    document.location.href=url;//send to delete action
                }},
                {addClass: 'btn btn-danger', text: translate['cancel'], onClick: function ($noty) {
                    $noty.close();
                    noty({force: true, text: translate['project_notdeleted'], type: 'error', layout: self.data('layout')});//Cancel
                }}
            ]
        });
        return false;
    });

    //project index
    $( ".project-mouseover" )
        .on( "mouseenter", function() {
            $(this).children(".project-btn").show();
            $(this).children(".project-img").hide();
        })
        .on( "mouseleave", function() {
            $(this).children(".project-btn").hide();
            $(this).children(".project-img").show();
        });


//hold new tags
    collectionTagsHolder.append($newLinkLiTag);
  $addTagLink.on('click', function(e) {
    e.preventDefault();
    addForm(collectionTagsHolder, $newLinkLiTag);
  });
  collectionTagsHolder.find('li.input').each(function() {
    addFormDeleteLink($(this));
  });
  //hold new projects
  collectionProjectsHolder.append($newLinkLiProject);
  $addProjectLink.on('click', function(e) {
    e.preventDefault();
    addForm(collectionProjectsHolder, $newLinkLiProject);
  });
  collectionProjectsHolder.find('li').each(function() {
    addFormDeleteLink($(this));
  });

  //hold new medias
  collectionMediasHolder.append($newLinkLiMedia);
  $addMediaLink.on('click', function(e) {
    e.preventDefault();
    addForm(collectionMediasHolder, $newLinkLiMedia);
  });
  collectionMediasHolder.find('li').each(function() {
    addFormDeleteLink($(this));
  });
  //hold new renders
  collectionRendersHolder.append($newLinkLiRender);
  $addRenderLink.on('click', function(e) {
    e.preventDefault();
    addForm(collectionRendersHolder, $newLinkLiRender);
  });
  collectionRendersHolder.find('li').each(function() {
    addFormDeleteLink($(this));
  });
  //hold type of input for the provider
  $(".providerSelector").each(function(){
        $(this).change(function(){
            var valueSelected = $('option:selected', this).text();
            var input = $(this).parent().parent().children(':first-child').children('.providerInput');
            if (valueSelected == "Dailymotion" || valueSelected == "Youtube" || valueSelected == "Vimeo") {
                $(input).attr('type', 'text');
            }
            if (valueSelected == "File" || valueSelected == "Image") {
                $(input).attr('type', 'file');
            }
        });
  });


    //manage select of project in index of projects
    $(".addToBook").on('click',function(e){
            e.preventDefault();
            var $this = $(this);
            var project = $this.parents('.project');

            if (project.hasClass('selected')) {
                project.removeClass('selected');
                project.find('.checkbox').removeAttr('checked');
                $this.find('.glyphicon-class').text(translate['book_add']);
            } else {
                project.addClass('selected');
                project.find('.checkbox').attr('checked', 'checked');
                $this.find('.glyphicon-class').text(translate['book_delete']);
            }

            var nbSelected = $('.checkbox[checked="checked"]').length;
            $('.numberProject').text(nbSelected);
            if (nbSelected === 0) $('.addBook').addClass('disabled');
            else $('.addBook').removeClass('disabled');
            /*if(thumbnail.css('border-width') == '1px')
            {
                nbProjectSelected++;
                thumbnail.css('border-width', '5px');
                thumbnail.css('border-color', 'black');
                projects=setProject(projects, value);
                $(this).parents('.project').addClass('selected');
                $(this).children(':last-child').text(translate['book_delete']);
            } else if(thumbnail.css('border-width') == '5px') {
                nbProjectSelected--;
                projects=unsetProject(projects, value);
                thumbnail.css('border-width', '1px');
                thumbnail.css('border-color', '#ddd');
                $(this).parents('.project').removeClass('selected');
                $(this).children('.glyphicon-class').text(translate['book_add']);
            }
            $(".numberProject").text(nbProjectSelected);
            if(nbProjectSelected > 0)
            {
                $(".numberProject").parent().removeClass('disabled');
            } else {
                $(".numberProject").parent().addClass('disabled');
            }*/
        //});

    });

    //send to add book action
    $(".addBook").on('click', function(){
        for (var i = 0; i < projects.length; i++) {
            if (projects[i]['project_select'] === true)
            {
                $(this).before("<input type='hidden' name='project["+i+"]' value='"+projects[i]['project_id']+"'/>");
            }
        }
    });

    if (typeof availableTags != "undefined"){
        $( ".tagInput").autocomplete({
            source: availableTags,
            messages: {
                noResults: '',
                results: function() {}
            }
        });
    }
    //search at project index
    $("#project_search_submit").on('click', function(){
        data = $('.project_result');
        if($('#no_result').length){
            $('#no_result').remove();
        }
        if ($('#project_search').val() !== '') {
            $('.project_result').hide();
            $('.selected').parent().show();
        }
        var search = $(this).parent().parent().find('#project_search').val();
        var list = "";
        if (search !== '') {
            var result = search.split(',');
            for(var string in result){
                $('.project_result[data-date="'+result[string]+'"]').show();
                $('.project_result[data-tag*="'+result[string]+'"]').show();
                //if you want to add a new type of search :
                //1. add an attr like data-value={{project.value}} inside the project index at the div of .project result
                //2. add a line here $('.project_result[data-value*="'+result[string]+'"]').show(); and suppress "*" if you want a strict search
                }
                if (!$('.project_result').is(':visible')){
                    $('.new_project').after('<h1><p class="highlight col-lg-12" id="no_result">'+translate['noresult']+'</p></h1>');
                }
            }
    });
    $('#project_search').on('keyup', function(){
        if ($(this).val() === '') {
            if($('#no_result').length){
                $('#no_result').remove();
            }
            $('.project_result').show();
        }
    });

    $("#book_search_submit").on('click', function(){
        if($('#no_result').length){
          $('#no_result').remove();
        }

        if ($('#book_search').val() !== '') {
            $('.book_result').hide();
        }
        var search= $(this).parent().find('#book_search').val();
        var list= "";
        if (search !== '') {
            var result= search.split(' ');
            for(var string in result){
                $('.book_result[data-name*="'+result[string]+'"]').show();
                list += '.'+result[string].toLowerCase();
            }
            if(!$('.book_result').is(':visible')){
                $('.new_book').after('<h1><p class="highlight col-lg-12" id="no_result">'+translate['noresult']+'</p></h1>');
            }
        }
    });
    $('#book_search').on('keyup', function(){
        if ($(this).val() === '') {
            if($('#no_result').length){
                $('#no_result').remove();
            }
            $('.book_result').show();
        }
    });
});
