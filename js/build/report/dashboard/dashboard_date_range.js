$.fn.dataTableExt.afnFiltering.push(
	function( oSettings, aData, iDataIndex ) {
		var iFini = document.getElementById('col0_filter_start').value;
		var iFfin = document.getElementById('col0_filter_end').value;
					
		var iStartDateCol = 0;
		var iEndDateCol   = 0;

		iFini=iFini.substring(6,10) + iFini.substring(3,5)+ iFini.substring(0,2);
		iFfin=iFfin.substring(6,10) + iFfin.substring(3,5)+ iFfin.substring(0,2);

		var datofini=aData[iStartDateCol].substring(6,10) + aData[iStartDateCol].substring(3,5)+ aData[iStartDateCol].substring(0,2);
		var datoffin=aData[iEndDateCol].substring(6,10) + aData[iEndDateCol].substring(3,5)+ aData[iEndDateCol].substring(0,2);

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
		function(oSettings, aData, iDataIndex) {
			var iFini = document.getElementById('col7_filter_start').value;
			var iFfin = document.getElementById('col7_filter_end').value;
			var iStartDateCol = 8;
			var iEndDateCol   = 8;

			iFini=iFini.substring(6,10) + iFini.substring(3,5)+ iFini.substring(0,2);
			iFfin=iFfin.substring(6,10) + iFfin.substring(3,5)+ iFfin.substring(0,2);

			var datofini=aData[iStartDateCol].substring(6,10) + aData[iStartDateCol].substring(3,5)+ aData[iStartDateCol].substring(0,2);
			var datoffin=aData[iEndDateCol].substring(6,10) + aData[iEndDateCol].substring(3,5)+ aData[iEndDateCol].substring(0,2);

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
		function(oSettings, aData, iDataIndex) {
			var iFini = document.getElementById('col10_filter_start').value;
			var iFfin = document.getElementById('col10_filter_end').value;
			var iStartDateCol = 11;
			var iEndDateCol   = 11;

			iFini=iFini.substring(6,10) + iFini.substring(3,5)+ iFini.substring(0,2);
			iFfin=iFfin.substring(6,10) + iFfin.substring(3,5)+ iFfin.substring(0,2);

			var datofini=aData[iStartDateCol].substring(6,10) + aData[iStartDateCol].substring(3,5)+ aData[iStartDateCol].substring(0,2);
			var datoffin=aData[iEndDateCol].substring(6,10) + aData[iEndDateCol].substring(3,5)+ aData[iEndDateCol].substring(0,2);

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
		function(oSettings, aData, iDataIndex) {
			var iFini = document.getElementById('col12_filter_start').value;
			var iFfin = document.getElementById('col12_filter_end').value;
			var iStartDateCol = 13;
			var iEndDateCol   = 13;

			iFini=iFini.substring(6,10) + iFini.substring(3,5)+ iFini.substring(0,2);
			iFfin=iFfin.substring(6,10) + iFfin.substring(3,5)+ iFfin.substring(0,2);

			var datofini=aData[iStartDateCol].substring(6,10) + aData[iStartDateCol].substring(3,5)+ aData[iStartDateCol].substring(0,2);
			var datoffin=aData[iEndDateCol].substring(6,10) + aData[iEndDateCol].substring(3,5)+ aData[iEndDateCol].substring(0,2);

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
		function(oSettings, aData, iDataIndex) {
			var iFini = document.getElementById('col13_filter_start').value;
			var iFfin = document.getElementById('col13_filter_end').value;
			var iStartDateCol = 14;
			var iEndDateCol   = 14;

			iFini=iFini.substring(6,10) + iFini.substring(3,5)+ iFini.substring(0,2);
			iFfin=iFfin.substring(6,10) + iFfin.substring(3,5)+ iFfin.substring(0,2);

			var datofini=aData[iStartDateCol].substring(6,10) + aData[iStartDateCol].substring(3,5)+ aData[iStartDateCol].substring(0,2);
			var datoffin=aData[iEndDateCol].substring(6,10) + aData[iEndDateCol].substring(3,5)+ aData[iEndDateCol].substring(0,2);

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