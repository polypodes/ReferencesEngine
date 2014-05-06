var collectionTagsHolder = $('ul.tags');
var $addTagLink = $('<a href="#" class="add_tag_link">Add tag</a>');
var $newLinkLiTag = $('<ul></ul>').append($addTagLink);


var collectionMediasHolder = $('ul.medias');
var $addMediaLink = $('<a href="#" class="add_media_link">Add Media</a>');
var $newLinkLiMedia = $('<ul></ul>').append($addMediaLink);


var collectionRendersHolder = $('ul.renders');
var $addRenderLink = $('<a href="#" class="add_render_link">Add Render</a>');
var $newLinkLiRender = $('<ul></ul>').append($addRenderLink);

function addForm(collectionHolder, $newLinkLi) {
    var prototype = collectionHolder.attr('data-prototype');

    var newForm = prototype.replace(/__name__/g, collectionHolder.children().length);

    var $newFormLi = $('<li></li>').append(newForm);
    $newLinkLi.before($newFormLi);
    addFormDeleteLink($newFormLi);
}

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
		noty({
			text        : 'Supprimer : "'+title+'" ?',
			type        : self.data('type'),
			dismissQueue: true,
			layout      : self.data('layout'),
			buttons     : [
				{addClass: 'btn btn-primary', text: 'Oui', onClick: function ($noty) {
					$noty.close();
					document.location.href='./remove/'+id;
				}
				},
				{addClass: 'btn btn-danger', text: 'Annuler', onClick: function ($noty) {
					$noty.close();
					noty({force: true, text: 'Le projet n\'a pas été supprimer.', type: 'error', layout: self.data('layout')});
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
  collectionTagsHolder.find('li').each(function() {
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

});