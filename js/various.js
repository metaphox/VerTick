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
		}).find("div.notran").css({
			//'margin' : '0 0.2em 0.1em 0.2em',
			'font-size' : '0.85em',
			'color'	: '#333',
			'margin' : '6px 2px 2px'			
		});
		$(this).find("div.tran").css({			 
			'-webkit-transform':'rotate(-90deg)',
		});
		$(this).css({			
			'-webkit-transform-origin' : 'top left',
			'-webkit-transform'	:	'rotate(90deg)',
			'margin-left'	: '40px',
			'width':'450px',
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