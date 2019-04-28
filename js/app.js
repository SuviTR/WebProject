window.addEventListener('load', () => {
	const el = $('#app');


	const router = new Router({
		mode: 'history',
	})


	router.add('/index.html', () => {
		showTemplate('index');
	})

	router.add('/test', () => {
		showTemplate('boxtemplate');
		$('#var1').html('Ykkönen');
	});

	router.navigateTo(window.location.pathname);

	const link = $(`a[href$='${window.location.pathname}']`);
	link.addClass('active');

	$('a.spa').on('click', (event) => {
		console.log('hello!');
		event.preventDefault();

		const target = $(event.target);

		console.log('target: ', target);

		const href = target.attr('href');
		const path = href.substr(href.lastIndexOf('/'));

		console.log(path);
		router.navigateTo(path);
	});


	function showTemplate(templateName) {
		templateName = "#" + templateName;
		let template = $(templateName).html();
		$('#app').html(template);
	}



})