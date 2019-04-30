window.addEventListener('load', () => {
	const el = $('#app');


	const router = new Router({
		mode: 'history',
	})


	router.add('/', () => {
		showTemplate('index');
	})

	router.add('/portfolio/project1', () => {
		showTemplate('project');
	});

	router.navigateTo(window.location.pathname);

	const link = $(`a[href$='${window.location.pathname}']`);
	link.addClass('active');


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