/**
 * Similar to the Date (dd/mm/YY) data sorting plug-in, this plug-in offers 
 * additional  flexibility with support for spaces between the values and
 * either . or / notation for the separators.
 *
 * Please note that this plug-in is **deprecated*. The
 * [datetime](//datatables.net/blog/2014-12-18) plug-in provides enhanced
 * functionality and flexibility.
 *
 *  @name Date (dd . mm[ . YYYY]) 
 *  @summary Sort dates in the format `dd/mm/YY[YY]` (with optional spaces)
 *  @author [Robert Sedovšek](http://galjot.si/)
 *  @deprecated
 *
 *  @example
 *    $('#example').dataTable( {
 *       columnDefs: [
 *         { type: 'date-eu', targets: 0 }
 *       ]
 *    } );
 */

jQuery.extend( jQuery.fn.dataTableExt.oSort, {
	"date-eu-pre": function ( date ) {
		date = date.replace(" ", "");	
		if(isHTML(date)) {
			var clear_tag =  ((date.replace(/(<\?[a-z]*(\s[^>]*)?\?(>|$)|<!\[[a-z]*\[|\]\]>|<!DOCTYPE[^>]*?(>|$)|<!--[\s\S]*?(-->|$)|<[a-z?!\/]([a-z0-9_:.])*(\s[^>]*)?(>|$))/gi, '')).replace(/<[^>]+>/gm, '')).replace(/\n/ig, '');
		} else {
			var clear_tag = date;
		}
		
		if (!clear_tag || clear_tag.trim() == '') {
			return 0;
		}
				
		var eu_date = clear_tag.trim().split(/[\.\-\/]/);
		
		var year;
		if ( eu_date[2] ) {
			year = eu_date[2];
		}
		else {
			year = 0;
		}

		var month = eu_date[1];
		if ( month.length == 1 ) {
			month = 0+month;
		}

		var day = eu_date[0];
		if (day.length == 1) {
			day = 0+day;
		}

		return (year + month + day) * 1;
	
	},
	"date-eu-asc": function ( a, b ) {
		return ((a < b) ? -1 : ((a > b) ? 1 : 0));
	},
	"date-eu-desc": function ( a, b ) {
		return ((a < b) ? 1 : ((a > b) ? -1 : 0));
	}	
});

jQuery.extend( jQuery.fn.dataTableExt.oSort, {
	"str-tag-pre": function ( str ) {
		str = str.replace(" ", "").replace("							", "");		
		if(isHTML(str)) {
			var clear_tag =  ((str.replace(/(<\?[a-z]*(\s[^>]*)?\?(>|$)|<!\[[a-z]*\[|\]\]>|<!DOCTYPE[^>]*?(>|$)|<!--[\s\S]*?(-->|$)|<[a-z?!\/]([a-z0-9_:.])*(\s[^>]*)?(>|$))/gi, '')).replace(/<[^>]+>/gm, '')).replace(/\n/ig, '');
		} else {
			var clear_tag = str;
		}
		
		if (!clear_tag || clear_tag.trim() == '') {
			return "";
		}
		
		console.log(clear_tag.trim());
				
		return clear_tag.trim()
		
	},
	"str-tag-asc": function ( a, b ) {
		return ((a < b) ? -1 : ((a > b) ? 1 : 0));
	},
	"str-tag-desc": function ( a, b ) {
		return ((a < b) ? 1 : ((a > b) ? -1 : 0));
	}	
});


function isHTML(str) {
    var doc = new DOMParser().parseFromString(str, "text/html");
    return Array.from(doc.body.childNodes).some(node => node.nodeType === 1);
}
