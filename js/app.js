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

	$('a.spa').on('click', (event) => {
		console.log('hello!');
		event.preventDefault();

		var target = $(event.target).closest('a');

		const href = target.attr('href');
		const path = href;

		console.log(path);
		router.navigateTo(path);
	});


	function showTemplate(templateName) {
		templateName = "#" + templateName;
		let template = $(templateName).html();
		$('#app').html(template);
	}



})