window.addEventListener('load', () => {
	const el = $('#app');
	const serv = 'http://vcust539.louhi.net:81';


	const router = new Router({
		mode: 'history',
	})


	router.add('/', () => {
		showTemplate('index');
		getAjaxData(showIndexData);
	})

	router.add('/portfolio/project1', () => {
		showTemplate('project');
	});

	router.navigateTo(window.location.pathname);

	const link = $(`a[href$='${window.location.pathname}']`);
	link.addClass('active');


	/* Contents functions */
	function getAjaxData(processingFunction) {
		httpRequest = new XMLHttpRequest();
		httpRequest.onreadystatechange = function () {
			if(httpRequest.readyState === XMLHttpRequest.DONE) {
				if(httpRequest.status === 200 ) {
					var result = JSON.parse(httpRequest.responseText)
					processingFunction(result);
				}
			}
		}

		console.log('address: ' + serv + '/cv/about');
		httpRequest.open('GET', serv + '/cv/about', true);
		httpRequest.send();
	}

	function showIndexData(json) {
		document.getElementById('aboutheading').innerHTML=json.heading;
		document.getElementById('aboutdescription')
		.innerHTML=json.description;
		document.getElementById('aboutimg').setAttribute('src', json.picture);
	}


	function showTemplate(templateName) {
		let template = document.getElementById(templateName);
		let app = document.getElementById('app');
		app.innerHTML = "";
		app.appendChild(template.content.cloneNode(true));

		$('a.spa').on('click', (event) => {
			event.preventDefault();

			var target = $(event.target).closest('a');

			const href = target.attr('href');
			const path = href;

			console.log(path);
			router.navigateTo(path);
		});
	}



})