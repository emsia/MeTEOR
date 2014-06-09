$(document).ready( function() 
	{
		$('.linka').each( function(i)
			{
				var $match = $('.viewtableA').eq(i);
				$(this).toggle( function() 
					{
						$match.slideDown();
					},
					function()
					{
						$match.slideUp();
					}
				);
			}
		);		
	}
);


