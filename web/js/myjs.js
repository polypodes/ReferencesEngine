$(document).ready(function () {
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
					noty({force: true, text: 'Le projet : "'+title+'"" a été supprimer.', type: 'success', layout: self.data('layout')});
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

});