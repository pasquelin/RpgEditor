$(function(){

		tableau ('#json_users', url_script+'users/resultatAjax', [null, null, null, null, {
				'bSortable': false
		}]);
		tableau ('#json_items', url_script+'items/resultatAjax', [null, {
				'bSortable': false
		}, null, {
				'bSortable': false
		}]);
		tableau ('#json_quetes', url_script+'quetes/resultatAjax', [null, null, null, null, null, null, null, {
				'bSortable': false
		}]);
		tableau ('#json_articles', url_script+'articles/resultatAjax', [null, null, null, null, {
				'bSortable': false
		}]);
		tableau ('#json_elements', url_script+'elements/resultatAjax', [null, null, null, null, null, null, null]);

		tableau ('#json_regions', url_script+'regions/resultatAjax', [null, null, null, null, null, {
				'bSortable': false
		}]);
		
});

function tableau (id, url, trie)
{
		if($(id).length)
		{
				$(id).dataTable( {
						'bProcessing': true,
						'bServerSide': true,
						'sPaginationType': 'full_numbers',
						'sAjaxSource': url,
						'bStateSave': true,
						'aoColumns': trie,
						'fnDrawCallback' : function () {
								$('.icon_list').tipsy();
						}
				} );	
				
	
				
		}
}