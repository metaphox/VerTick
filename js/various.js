//translate comment count into chinese on the fly
function ch_num_l1k(num) {
	if(num.length > 4) return '上万';
	while(num.length < 4){ num = '0' + num;	} //stuff with 0 leftside
	var cnnumber = ['〇', '一', '二', '三', '四', '五', '六', '七', '八', '九'];
 	var cnunit = ['千', '百', '十', ''];
	var seennil = false; var seensth = false; var r = [];
	for(i=0;i<4;i++){ var n = num.substring(i, i+1);
		if(n=='0'){ if(seensth && !seennil){ //put 0 if there werent any
				r.push(cnnumber[0]); seennil=true;
		} }else{ r.push(cnnumber[n]); r.push(cnunit[i]); seensth = true; } }
	while(r[r.length-1] == cnnumber[0]){ r.pop(); }
	return r.join("") ? r.join("") : cnnumber[0];
}

/**
 * A (almost) complete explaination to the regular expression used for finding out
 	which characters should be rotated. In a perfect world, unicode scripts like
 	\p{Han} could be able to find out all chinese chars in one run, but only very
 	few regular expression engines support unicode scripts today. Perl does,
 	Javascript doesn't. Yet even if unicode script works in Javascript, those punc-
 	tuations that need to be rotated might still needed to be picked out by hand. 
 	
 	var reIdeography = /^[
 		#following chars should be rotated
 		\u0F00-\u0FFF	#Tibeten
 		\u3100-\u312F	#BPMF
 		\u31A0-\u31BF	#BPMF Ext
 		\u4E00-\u9C9F	#CJK Unified
 		\u3400-\u4DBF	#CJK Ext A
 		\u20000-\u2A6D6	#CJK Ext B
 		\u2A700-\u2B73F	#CJK Ext C
 		\uF900-\uFAFF	#CJK Compatibility Ideographs
		\u2F800-\u2FA1F	#CJK Compatibility Ideographs Supplement
		\u2F00-\u2FDF	#CJK Radicals, KangXi Radicals
		\u2E80-\u2EFF	#CJK Radicals Supplement
		\u31C0-\u31EF	#CJK Strokes
		\u2FF0-\u2FFF	#Ideographic Description Characters
		\u1100-\u11FF	#Hangul Jamo
		\uA960-\uA97F	#Hangul Jamo Extended-A
		\uD7B0-\uD7FF	#Hangul Jamo Extended-B
		\u3130-\u318F	#Hangul Compatibility Jamo
		#\uFF00 till \uFFEF, Halfwidth Jamo, Katakana, has various puncs and chars
		# that either have to be rotated or have to be left unchanged. those need
		# to be NOT rotated, AND those need to be rotated AND adjusted, are kept
		# here but commented out
		\uFF01-\uFF06	#rotate only
		#\uFF07-\uFF09	#no-rotate
		\uFF0A\uFF0B	#rotate only, * +
		#\uFF0C			#rotate adjust, chinese comma
		#\uFF0D			#no-rotate, hyphen-minus
		#\uFF0E			#rotate adjust, chinese full stop, point
		\uFF0F-\uFF1B	#rotate only, slash, fullwidth numbers, :, ;
		#\uFF1C-\uFF1E	#no-rotate, <, =, >
		\uFF1F-\uFF3A	#rotate only
		#\uFF3B			#no-rotate, [
		\uFF3C			#rotate only, backslash
		#\uFF3D-\uFF40	#no-rotate, ], ^, _, `
		\uFF41-\uFF5A	#rotate only
		#\uFF5B-\uFF60	#no-rotate, {, |, }, ~, fullwidth left,right white parenthesis
		#\uFF61			#rotate adjust, chinese full stop, circle
		#\uFF62\uFF63	#no-rotate, 「, 」
		#\uFF64			#rotate adjust, 、
		\uFF65-\uFF9F	#rotate only, katakana halfwidth	???
		\uFFA0-\uFFE1	#rotate only, jamo halfwidth
		#\uFFE2-\uFFE4	#no-rotate, fullwidth not sign, macron, broken bar
		\uFFE5\uFFE6	#rotate only, yen sign, won sign
		#\uFFE8-\uFFEE	#no-rotate, form vertical, 4 directions, black sq, white circle
		\uAC00-\uD7AF	#rotate only, Hangul Syllables
		\u3040-\u309F	#rotate only, Hiragana
		\u30A0-\u30FF	#rotate only, Katakana
		\u31F0-\u31FF	#rotate only, Katakana Phonetic Extensions
		
		#\u3000 till \u303F, CJK Symbols and Punctuation, is in the similar situation
		# as \uFF00 till \uFFEF.
		
 		]/ // modifier x is NOT supported by js it seems...
 		;
 	
 	//now we match all those chars that need to be rotated and adjusted.
 	var reRotateAdjust = /^[
 		\uFF0C\uFF0E\uFF61\uFF64	
 		]/ // modifier x ist NOT supported by js it seems...
 		;
*/


//fix article titles' h2
function vertilizeArticleH2(){
	var re1 = new RegExp("^[\u3000-\u3007\u30122\u3100-\uFA29\uFF01-\uFFEE]*$"); //CJK chars
	$('div#content div.posttitle h2 a').each(function(){
		var oText = $(this).text();
		$(this).text('');
		$(this).css({'height':'38px', 'display':'block'});
		var nonideo = []; var next; var result = [];
		for(i=0, j=oText.length; i<j; i++){
			if(!re1.test(oText[i])){
				nonideo.push(oText[i]);
				continue;
			}
			if(nonideo.length){
				result.push('<div class="notran">'+nonideo.join('')+'</div>');
				nonideo = [];
			}
			result.push('<div class="tran">'+ oText[i] +'</div>');				
		}
		if(nonideo.length){ //in case the text ends with non-ideograph chars
			result.push('<div class="notran">'+nonideo.join('')+'</div>');
			nonideo = [];
		}
		$(this).html(result.join(''));
		$(this).find("div").css({
//			'position'	:	'relative',
			'float'		:	'left',
		});
		$(this).find("div.notran").css({
			//'margin' : '0 0.2em 0.1em 0.2em',
			'font-size' : '0.85em',
			'margin' : '6px 6px 2px 2px'
		});
		$(this).find("div.tran").css({			 
			'-webkit-transform'	: 'rotate(-90deg)',
			'-moz-transform'	: 'rotate(-90deg)',
			'-o-transform'		: 'rotate(-90deg)',
		});
		$(this).css({			
			'-webkit-transform-origin'	: 'top left',
			'-moz-transform-origin' 	: 'top left',
			'-o-transform-origin'		: 'top left',
			'-webkit-transform'			: 'rotate(90deg)',
			'-moz-transform'			: 'rotate(90deg)',
			'-o-transform'				: 'rotate(90deg)',
			'margin-left'	: 	'40px',
			'width'			:	'450px',
		});
/*
		$(this).hover(function(){
			$(this).css({
				'overflow':'visible',
				'background' : '#eeeeee'
			});
		},
		function(){
			$(this).css({
				//'overflow':'hidden',
				'background' : 'transparent'
			});
		});
*/
	});
}