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