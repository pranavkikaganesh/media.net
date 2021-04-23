var noPagesCrawled = document.getElementById('no_pages_crawled').style.display;
var search = document.getElementById('search').style.display;

document.getElementById('add_page').getElementsByTagName('a')[0].onclick = () => {
	noPagesCrawled = document.getElementById('no_pages_crawled').style.display;
	search = document.getElementById('search').style.display;
	document.getElementById('add_page').style.display = "none";
	document.getElementById('no_pages_crawled').style.display = "none";
	document.getElementById('search').style.display = "none";
	document.getElementById('page_form').style.display = "block";
	return false;
}

document.getElementById('cancel').onclick = () => {
	document.getElementById('add_page').style.display = "block";
	document.getElementById('no_pages_crawled').style.display = noPagesCrawled;
	document.getElementById('search').style.display = search;
	document.getElementById('page_form').style.display = "none";
	
	return false;
}

document.getElementById('crawling').onclick = () => {
	let urls = document.getElementById('urls').getElementsByTagName('textarea')[0].value.split("\n");
	let total = urls.length;
	let exe = []
	
	document.getElementById('urls').style.display = "none";
	document.getElementById('crawling').style.display = "none";
	document.getElementById('cancel').style.display = "none";
	document.getElementById('crawling_loader').style.display = "block";
	document.getElementById('crawling_loader').getElementsByTagName('span')[0].innerHTML = 'Crawling 0 out of '+total;
	
	for (let i = 0; i < urls.length; i++) {
		exe.push(pageCrawling(urls[i], i + 1, total));
	}
	
	Promise.all(exe)
	.then(() => {
		document.getElementById('add_page').style.display = "block";
		document.getElementById('search').style.display = "block";
		document.getElementById('page_form').style.display = "none";
		document.getElementById('urls').style.display = "block";
		document.getElementById('crawling').style.display = "inline-block";
		document.getElementById('cancel').style.display = "inline-block";
		document.getElementById('crawling_loader').style.display = "none";
	});
}

const pageCrawling = (url, index, total) => {
	return new Promise((resolve, reject) => {
		let xhttp = new XMLHttpRequest();
		xhttp.open("POST", 'crawling.php');
		xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		xhttp.send('url='+url);
		xhttp.onload = () => {
			let res = xhttp.responseText;
			
			if (res == 1) {
				document.getElementById('crawling_loader').getElementsByTagName('span')[0].innerHTML = 'Crawling '+index+' out of '+total;
			}
			resolve();
		};
	});
}

document.getElementById('do_search').onclick = () => {
	document.getElementById('result').innerHTML = "<img src='loader.gif'>";
	let xhttp = new XMLHttpRequest();
	xhttp.open("POST", 'search.php');
	xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xhttp.send('search_for='+document.getElementById('search_for').value);
	xhttp.onload = () => {
		let html = '';
		try {
			let rows = JSON.parse(xhttp.responseText);
			for (row of rows) {
				html += '<p><a href="'+row['url']+'" target="_blank">'+row['title']+'</a></p>'
			}
		} catch(e) {
		}
		if (html == '') {
			html = '<p>No result found</p>';
		}
		document.getElementById('result').innerHTML = html;
	};
}

document.getElementById("search_for").addEventListener("keyup", e => {
	if (e.keyCode === 13) {
		document.getElementById('do_search').click();
	}
});