const el = $('#app');
const serv = '/api';

const router = new Router({
	mode: 'history',
})

window.addEventListener('load', app);

function app() {


	router.add('/', () => {
		showTemplate('index');

		getAjaxData('/cv/front', 'GET', showFront);

		getAjaxData('/cv/about', 'GET', showAbout);

		getAjaxData('/cv/skills', 'GET', showSkills);

		getAjaxData('/cv/experience', 'GET', showExperience);

		getAjaxData('/cv/education', 'GET', showEducation);

		getAjaxData('/portfolio', 'GET', showPortfolio);

		getAjaxData('/cv/contact', 'GET', showContact);
	})

	router.add('/portfolio/(:any)', (id) => {
		showTemplate('project');
		getAjaxData('/portfolio/' + id, 'GET', showProject);
	});

	router.add('/login', () => {
		showTemplate('login');
	})

	router.navigateTo(window.location.pathname);

	const link = $(`a[href$='${window.location.pathname}']`);
	link.addClass('active');


	loginButton = document.getElementById('login');
	loginButton.onClick

}

function showLogin() {
	$( "#loginform" ).toggle();
}

function login(form) {
	console.log(form.action);
	console.log(form.Username.value);
	console.log(form.Password.value);

	getAjaxData('/login', 'POST', (json) => {
		console.log(json);
	})
}

/* Contents functions */
function getAjaxData(address, method, processingFunction) {
	var httpRequest = new XMLHttpRequest();
	httpRequest.onreadystatechange = function () {
		if(httpRequest.readyState === XMLHttpRequest.DONE) {
			if(httpRequest.status === 200 ) {
				
				console.log(httpRequest.responseText);
				var json = JSON.parse(httpRequest.responseText)
				processingFunction(json);
			}
		}
	}

	console.log(serv + address);
	httpRequest.open(method, serv + address, true);
	httpRequest.send();
}


function showTemplate(templateName) {
	let template = document.getElementById(templateName);
	let app = document.getElementById('app');
	app.textContent = "";
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


function showFront(json) {
			json = json[0];
			document.getElementById('fullname').textContent=json.Fullname;
			document.getElementById('profession')
			.textContent=json.Profession;
			document.getElementById('frontpicture').setAttribute('src', json.FrontPicture);
}

function showAbout(json) {
			json = json[0];
			document.getElementById('aboutheading').textContent=json.Heading;
			document.getElementById('aboutdescription')
			.innerHTML=json.Description;
			document.getElementById('aboutimg').setAttribute('src', json.AboutPicture);
		}

function showSkills(json) {
	var id = document.getElementById('skillsdiv');
	var table = id.getElementsByTagName('table')[0];
	var template = document.getElementById('skillsrow');

	for(var i = 0; i < json.length; i++) {
		var row = document.importNode(template.content, true);
		row.querySelector('.skillsname').textContent
		= json[i].Name;
		
		var bar = row.querySelector('.skillsbarvalue');
		bar.setAttribute('class', 'skillsbarvalue value-' + json[i].SkillLevel);
		row.querySelector('.skillsvalue').textContent
		= json[i].SkillLevel;
		table.appendChild(row);

	}
}

function showExperience(json) {
	var id = document.getElementById('expdiv');
	var table = id.getElementsByTagName('table')[0];
	var template = document.getElementById('exprow');

	for(var i = 0; i < json.length; i++) {
		var row = document.importNode(template.content, true);
		row.querySelector('.time').textContent
		= json[i].Exp_Year;
		row.querySelector('.experiencep').textContent
		= json[i].Title;
		row.querySelector('.expplace').textContent
		= json[i].Company;
		row.querySelector('.expdesc').textContent
		= json[i].Description;
		table.appendChild(row);

	}
}

function showEducation(json) {
	var id = document.getElementById('edudiv');
	var table = id.getElementsByTagName('table')[0];
	var template = document.getElementById('edurow');

	for(var i = 0; i < json.length; i++) {
		var row = document.importNode(template.content, true);

		row.querySelector('.time').textContent
		= json[i].Edu_Year;
		row.querySelector('.experiencep').textContent
		= json[i].Degree;
		row.querySelector('.educationp').textContent
		= json[i].Academy;
		row.querySelector('.educationpi').textContent
		= json[i].Description;
		table.appendChild(row);

	}
}

function showPortfolio(json) {
	var id = document.getElementById('portfoliodiv');
	var row = id.getElementsByClassName('row2')[0];
	var template = document.getElementById('portfolioproject');

	for(var i = 0; i < json.length; i++) {
		var project = document.importNode(template.content, true);

		var link = project.querySelector('a');
		link.setAttribute('href', '/portfolio/' + json[i].PId);
		var image = project.querySelector('.image');
		image.setAttribute('src', json[i].Picture);
		project.querySelector('.name').textContent
		= json[i].Name;
		project.querySelector('.portfolioinfo').textContent
		= json[i].Subtitle;
		row.appendChild(project);

	}
}

function showContact(json) {
	json = json[0];

	document.getElementById('phone_number').textContent=json.Phone;
	document.getElementById('email_address').textContent=json.Mail;
	document.getElementById('street_address').textContent=json.Address;

}

function showProject(json) {
	json = json[0];

	var content = document.getElementsByClassName('columnportfolio2')[0];
	content.getElementsByTagName('h3')[0].textContent = json.Subtitle;
	var textArea = content.querySelector('.portfoliocolumn');
	textArea.innerHTML = json.Description;

	var pictureArea = document.getElementsByClassName('columnportfolio')[0];
	var imagetag = pictureArea.getElementsByTagName('img')[0];
	console.log(imagetag);
	pictureArea.textContent = "";
	for(key in json.Pictures) {
		var clone = imagetag.cloneNode();
		clone.setAttribute('src', json.Pictures[key]);
		console.log(clone);
		console.log(key);
		pictureArea.appendChild(clone);

	}



}