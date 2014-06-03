// var collectionProjects_addHolder = $('ul.projects_add');
// var $addProject_addLink = $('<a href="#" class="add_project_link">Add a project</a>');
// var $newLinkLiProject_add = $('<ul></ul>').append($addProject_addLink);


//thumb order by date old

function OrderByDateOld()
{

}

function getArrayOfDataValue(value, dataclass)
{
  var DataArray= [];
  var i;
  i=0;
  $(dataclass).each(function(){
    DataArray[i]= $(this).data(value);
    i++;
  });
  return DataArray;
}

function enter(e) {
    if (e.keyCode == 13) {
      $(".sub").trigger('click');
      return false;
    }
}

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
        thisImgHeight= $(this).find('.img').find('.media-object').height();
        $(this).find('.img').width(320);
        if(thisHeight > tallest) { 
            if (thisHeight > 450) {
                thisHeight=450;
            };      
            tallest = thisHeight;       
        } 
        if(thisImgHeight < 320){
          $(this).find('.img').css('height',thisImgHeight);
        } else{
          $(this).find('.img').css('height', '320');
        }
    });    
    group.each(function() { $(this).height(tallest); });
}

//Transform a string to an array with , as separator

function searchToArray(string){

  var k =0;
  string = $.trim(string);
  var result ="";
  var array_search = [];
  for (var i = 0; i<string.length ; i++) {
    if(string[i] == ','){
      array_search[k] = $.trim(result);
      result='';
      k++;
      i++;
    }
    result += string[i];
  };
  if (result != 'undefined') {
    array_search[k] = $.trim(result);
  };

  return array_search;
}

//Transform a string to an array with escape as separator

function stringToArray(string){

  var k =0;
  string = $.trim(string);
  var result ="";
  var array_string = [];
  for (var i = 0; i<string.length ; i++) {
    if(string[i] == ' '){
      array_string[k] = $.trim(result);
      result='';
      k++;
      while(string[i] == ' '){
        i++;
      }
    }
    result += string[i];
  };
  if (result != 'undefined') {
    array_string[k] = $.trim(result);
  };

  return array_string;
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
        if (valueSelected == "Dailymotion" || valueSelected == "Youtube" || valueSelected == "Vimeo")
        {
          changeTypeInput(input, 'text');
        }
        if (valueSelected == "File" || valueSelected == "Image"){
          changeTypeInput(input, "file");
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

// Select a project

function setProject(project_array, id)
{
  for (var i = 0; i < project_array.length; i++) {
    if(project_array[i]['project_id'] == id)
    {
      project_array[i]['project_select'] = true;
    }
  };
  return project_array;
}

//unselect a project

function unsetProject(project_array, id)
{
  for (var i = 0; i < project_array.length; i++) {
    if(project_array[i]['project_id'] == id)
    {
      project_array[i]['project_select'] = false;
    }
  };
  return project_array;
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

//change the type of an input !Warning!

function changeTypeInput(input, type)
{
  var parent = input.parent();
  name = input.attr('name');
  id = input.attr('id');
  className = input.attr('class');
  newInput = parent.append('<input type="'+type+'" id="'+id+'" name="'+name+'" class="'+className+'"/>');
  input.remove();
}

$(document).ready(function () {
  equalHeight($(".thumbnail")); 
  var translate= getTranslation();

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





  var nbProject = $(".project").length; // get the number of project
  var projects = new Array(nbProject); 
  for (var i = 0; i < nbProject; i++ ) {
      projects[i] = new Array(2);
  }
  var nbProjectSelected=0;
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
	$('.btn-remove').on('click',function () {
		var self = $(this);
		var id = $(this).data('id');
		var title = $(this).data('title');
    var url = $(this).data('url');
		noty({
			text        : translate['suppress']+' : "'+title+'" ?',
			type        : self.data('type'),
			dismissQueue: true,
			layout      : self.data('layout'),
			buttons     : [
				{addClass: 'btn btn-primary', text: translate['yes'], onClick: function ($noty) {
					$noty.close();
					document.location.href=url;
				}
				},
				{addClass: 'btn btn-danger', text: translate['cancel'], onClick: function ($noty) {
					$noty.close();
					noty({force: true, text: translate['project_notdeleted'], type: 'error', layout: self.data('layout')});
				}
				}
			]
		});
		return false;
	});
	$( ".project-mouseover" )
  .on( "mouseenter", function() {
    	$(this).children(".project-btn").show();
    	$(this).children(".project-img").hide();
  })
  .on( "mouseleave", function() {
    	$(this).children(".project-btn").hide();
    	$(this).children(".project-img").show();
  });



	collectionTagsHolder.append($newLinkLiTag);
  $addTagLink.on('click', function(e) {
    e.preventDefault();
    addForm(collectionTagsHolder, $newLinkLiTag);
  });
  collectionTagsHolder.find('li.input').each(function() {
    addFormDeleteLink($(this));
  });

  collectionProjectsHolder.append($newLinkLiProject);
  $addProjectLink.on('click', function(e) {
    e.preventDefault();
    addForm(collectionProjectsHolder, $newLinkLiProject);
  });
  collectionProjectsHolder.find('li').each(function() {
    addFormDeleteLink($(this));
  });


  collectionMediasHolder.append($newLinkLiMedia);
  $addMediaLink.on('click', function(e) {
    e.preventDefault();
    addForm(collectionMediasHolder, $newLinkLiMedia);
  });
  collectionMediasHolder.find('li').each(function() {
    addFormDeleteLink($(this));
  });
  collectionRendersHolder.append($newLinkLiRender);
  $addRenderLink.on('click', function(e) {
    e.preventDefault();
    addForm(collectionRendersHolder, $newLinkLiRender);
  });
  collectionRendersHolder.find('li').each(function() {
    addFormDeleteLink($(this));
  });
  $(".providerSelector").each(function(){
      $(this).change(function(){
        var valueSelected=$('option:selected', this).text();
        var input=$(this).parent().parent().children(':first-child').children('.providerInput');
        if (valueSelected == "Dailymotion" || valueSelected == "Youtube" || valueSelected == "Vimeo")
        {
          changeTypeInput(input, 'text');
        }
        if (valueSelected == "File" || valueSelected == "Image"){
          changeTypeInput(input, "file");
        }
        });
  });
  var i = 0;
  $(".selector").each(function(){
    var value = $(this).parent().parent().parent().find(':hidden').val();
    projects[i]= {
        'project_id' : value,
        'project_select' : false
      };
    i++;
    $(this).on('click', function(e){
      e.preventDefault();
      var thumbnail = $(this).parent().parent().parent();
      var value = thumbnail.find(':hidden').val();
      
      if(thumbnail.css('border-width') == '1px')
      {
        nbProjectSelected++;
        thumbnail.css('border-width', '5px');
        thumbnail.css('border-color', 'black');
        projects=setProject(projects, value);
        $(this).parents('.project').addClass('selected');
        $(this).children(':last-child').text(translate['book_delete']);
      }else if(thumbnail.css('border-width') == '5px')
      {
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
      }else {
        $(".numberProject").parent().addClass('disabled');
      }
    })

  })
  $(".addBook").on('click', function(){
  for (var i = 0; i < projects.length; i++) {
    if(projects[i]['project_select'] == true)
    {
      $(this).before("<input type='hidden' name='project["+i+"]' value='"+projects[i]['project_id']+"'/>");
    }
  };
  })
  if (typeof availableTags != "undefined"){
    $( ".tagInput").autocomplete({
      source: availableTags,
      messages: {
        noResults: '',
        results: function() {}
    }
    });
  };
  $("#project_search_submit").on('click', function(){
    data=getArrayOfDataValue('date', '.project_result');
    if($('#no_result').length){
      $('#no_result').remove();
    }
    if ($('#project_search').val() != '') {
            $('.project_result').hide();
            $('.selected').parent().show();
          };
    var search= $(this).parent().parent().find('#project_search').val();
    var list= "";
    if (search != '') {
         var result= searchToArray(search);
      for(string in result){
        $('.project_result[data-date="'+result[string]+'"]').show();
        $('.project_result[data-tag*="'+result[string]+'"]').show();
      }
      if($('.project_result').is(':visible')){   
      }else{
        $('.new_project').after('<h1><p class="highlight col-lg-12" id="no_result">'+translate['noresult']+'</p></h1>');
      }
      
    }
  });
  $('#project_search').on('keyup', function(){
    if ($(this).val() == '') {
      if($('#no_result').length){
      $('#no_result').remove();
    }
      $('.project_result').show();
    };
  })
$("#book_search_submit").on('click', function(){
    if($('#no_result').length){
      $('#no_result').remove();
    }

    if ($('#book_search').val() != '') {
            $('.book_result').hide();
          };
    var search= $(this).parent().find('#book_search').val();
    var list= "";
    if (search != '') {
         var result= stringToArray(search);
      for(string in result){
        $('.book_result[data-name*="'+result[string]+'"]').show();
        list += '.'+result[string].toLowerCase();
      }
      if($('.book_result').is(':visible')){   
      }else{
        $('.new_book').after('<h1><p class="highlight col-lg-12" id="no_result">'+translate['noresult']+'</p></h1>');
      }
      
    }
  });
  $('#book_search').on('keyup', function(){
    if ($(this).val() == '') {
      if($('#no_result').length){
      $('#no_result').remove();
    }
      $('.book_result').show();
    };
  })
});