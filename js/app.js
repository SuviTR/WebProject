window.addEventListener('load', () => {
	const el = $('#app');
	const serv = 'http://vcust539.louhi.net:81';
	var json;


	const router = new Router({
		mode: 'history',
	})


	router.add('/', () => {
		showTemplate('index');

		getAjaxData('/cv/front', function(json) {
			document.getElementById('fullname').innerHTML=json.fullname;
			document.getElementById('profession')
			.innerHTML=json.profession;
			document.getElementById('frontpicture').setAttribute('src', json.FrontPicture);
		});

		getAjaxData('/cv/about', function(json) {
			document.getElementById('aboutheading').innerHTML=json.heading;
			document.getElementById('aboutdescription')
			.innerHTML=json.description;
			document.getElementById('aboutimg').setAttribute('src', json.picture);
		});
	})

	router.add('/portfolio/project1', () => {
		showTemplate('project');
	});

	router.navigateTo(window.location.pathname);

	const link = $(`a[href$='${window.location.pathname}']`);
	link.addClass('active');


	/* Contents functions */
	function getAjaxData(address, processingFunction) {
		httpRequest = new XMLHttpRequest();
		httpRequest.onreadystatechange = function () {
			if(httpRequest.readyState === XMLHttpRequest.DONE) {
				if(httpRequest.status === 200 ) {
					var json = JSON.parse(httpRequest.responseText)
					processingFunction(json);
				}
			}
		}

		console.log('address: ' + serv + address);
		httpRequest.open('GET', serv + address, true);
		httpRequest.send();
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