$.fn.dataTableExt.afnFiltering.push(
	function( oSettings, aData, iDataIndex ) {
		var iFini = document.getElementById('col1_filter_start').value;
		var iFfin = document.getElementById('col1_filter_end').value;
							
		var iStartDateCol = 1;
		var iEndDateCol   = 1;

		var datofini = aData[iStartDateCol];
		var datoffin = aData[iEndDateCol];

		if( iFini === "" && iFfin === "" ) {
			return true;
		}
		else if ( iFini == datofini && iFfin === "") {
			return true;
		}
		else if ( iFfin == datoffin && iFini === "") {
			return true;
		}
		else if (iFini <= datofini && iFfin >= datoffin) {
			return true;
		}
				
		return false;
				
});

$.fn.dataTableExt.afnFiltering.push(
	function( oSettings, aData, iDataIndex ) {
		var iFini 	   = document.getElementById('col6_filter_start').value.replace(',', '');
		var iFfin 	   = document.getElementById('col6_filter_end').value.replace(',', '');
								
		var iStartDateCol = 7;
		var iEndDateCol   = 7;

		var datofi_str = aData[iStartDateCol];
		var dotoff_str = aData[iEndDateCol];

		
		var datofini   = aData[iStartDateCol].replace(',', '');
		var datoffin   = aData[iEndDateCol].replace(',', '');

		if( iFini === "" && iFfin === "" ) {
			return true;
		}
		else if ( iFini == datofini && iFfin === "") {
			return true;
		}
		else if ( iFfin == datoffin && iFini === "") {
			return true;
		}
		else if (iFini <= datofini && iFfin >= datoffin) {
			return true;
		}
					
		return false;
					
});

$.fn.dataTableExt.afnFiltering.push(
		function( oSettings, aData, iDataIndex ) {
			var iFini 	   = document.getElementById('col11_filter_start').value.replace(',', '');
			var iFfin 	   = document.getElementById('col11_filter_end').value.replace(',', '');
									
			var iStartDateCol = 12;
			var iEndDateCol   = 12;

			var datofi_str = aData[iStartDateCol];
			var dotoff_str = aData[iEndDateCol];

			
			var datofini   = aData[iStartDateCol].replace(',', '');
			var datoffin   = aData[iEndDateCol].replace(',', '');

			if( iFini === "" && iFfin === "" ) {
				return true;
			}
			else if ( iFini == datofini && iFfin === "") {
				return true;
			}
			else if ( iFfin == datoffin && iFini === "") {
				return true;
			}
			else if (iFini <= datofini && iFfin >= datoffin) {
				return true;
			}
						
			return false;
						
});

$.fn.dataTableExt.afnFiltering.push(
		function( oSettings, aData, iDataIndex ) {
			var iFini 	   = document.getElementById('col14_filter_start').value.replace(',', '');
			var iFfin 	   = document.getElementById('col14_filter_end').value.replace(',', '');
									
			var iStartDateCol = 15;
			var iEndDateCol   = 15;

			var datofi_str = aData[iStartDateCol];
			var dotoff_str = aData[iEndDateCol];

			
			var datofini   = aData[iStartDateCol].replace(',', '');
			var datoffin   = aData[iEndDateCol].replace(',', '');

			if( iFini === "" && iFfin === "" ) {
				return true;
			}
			else if ( iFini == datofini && iFfin === "") {
				return true;
			}
			else if ( iFfin == datoffin && iFini === "") {
				return true;
			}
			else if (iFini <= datofini && iFfin >= datoffin) {
				return true;
			}
						
			return false;
						
});