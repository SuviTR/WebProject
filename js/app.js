const el = $('#app');
const serv = '/api';

const router = new Router({
	mode: 'history',
})

window.addEventListener('load', app);

function app() {


	router.add('/', () => {
		showTemplate('index');
		showNav();

		ajaxRequest('/cv/front', showFront);

		ajaxRequest('/cv/about', showAbout);

		ajaxRequest('/cv/skills', showSkills);

		ajaxRequest('/cv/experience', showExperience);

		ajaxRequest('/cv/education', showEducation);

		ajaxRequest('/portfolio', showPortfolio);

		ajaxRequest('/cv/contact', showContact);
	})

	router.add('/portfolio/(:any)', (id) => {
		showTemplate('project');
		ajaxRequest('/portfolio/' + id, showProject);
	});

	router.add('/login', () => {
		showTemplate('login');
	})

	router.add('/resume', () => {
		showTemplate('resume');
	})

	router.add('/edit', () => {
		showTemplate('index');
		showNav();
		showEditLinks();
	})

	router.navigateTo(window.location.pathname);

	const link = $(`a[href$='${window.location.pathname}']`);
	link.addClass('active');

}

function showNav() {
	$( '#navbar').show()
}

function hideNav() {
	$( '#navbar').hide()
}


/* Login functions */ 
function showLogin() {
	$( "#loginform" ).toggle();
}

function login(form) {
	var data = {"Username": form.Username.value,
				"Password": form.Password.value};


	ajaxRequest('/login', (json) => {
		console.log(json);
		alert(json.Message);
	}, 'POST', data);

	$( "#loginform").hide();
}

/* Ajax functions */
function ajaxRequest(address, processingFunction, method = 'GET', data) {
	//Data must be JSON
	var httpRequest = new XMLHttpRequest();
	httpRequest.onreadystatechange = function () {
		if(httpRequest.readyState === XMLHttpRequest.DONE) {
			if(httpRequest.status === 200 ) {
				
				var json = JSON.parse(httpRequest.responseText)
				processingFunction(json);
			}
		}
	}

	httpRequest.open(method, serv + address, true);
	httpRequest.send(JSON.stringify(data));
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

		hideNav();
		router.navigateTo(path);
	});
}

function printResume() {
    window.print();
}

/* Contents functions */
function showEditLinks() {

}

function showEditViews() {

	var template;
	var contents;

	//front
	template = document.getElementById('frontedit');
	contents = document.importNode(template.content, true);
	var front = document.getElementById('frontpagediv');
	front.innerHTML = "";
	front.appendChild(contents);

	//about
	template = document.getElementById('aboutedit');
	contents = document.importNode(template.content, true);
	var about = document.getElementById('aboutdiv');

	var aboutimg = about.querySelector('.column');
	aboutimg.innerHTML = "";
	aboutimg.appendChild(contents.querySelector('#inputaboutimg'));

	var text = about.querySelector('.column2');
	text.innerHTML = "";
	text.appendChild(contents.querySelector('#inputhello'));
	text.appendChild(contents.querySelector('.aboutcolumn'));
	text.appendChild(contents.querySelector('.save'));


	//skills
	template = document.getElementById('skillsedit');
	contents = document.importNode(template.content, true);
	var skills = document.getElementById('skillsdiv');

	skills.appendChild(contents);

	skills.querySelector('.add').onclick
		= function () { addRow('skillseditrow','#sklsdiv > table'); };

	//experience
	template = document.getElementById('skillsedit');
	contents = document.importNode(template.content, true);
	var experience = document.getElementById('experiencediv');

	contents.querySelector('button.add').textContent = "Add new experience";

	experience.appendChild(contents);

	experience.querySelector('.add').onclick
		= function() { addRow('experienceeditrow', "#expdiv > table"); };

	//education
	template = document.getElementById('skillsedit');
	contents = document.importNode(template.content, true);
	var education = document.getElementById('educationdiv');

	contents.querySelector('button.add').textContent = "Add new education";

	education.appendChild(contents);

	education.querySelector('.add').onclick
		= function() { addRow('educationeditrow', "#edudiv > table"); };

	//portfolio
	template = document.getElementById('portfolioedit');
	contents = document.importNode(template.content, true);
	var portfolio = document.getElementById('portfoliodiv');

	portfolio.appendChild(contents);

	portfolio.querySelector('.add').onclick
		= function() { addRow('projectadd', ".row2"); };

	//contact
	template = document.getElementById('contactedit');
	contents = document.importNode(template.content, true);
	var contact = document.getElementById('contact');
	console.log(contact);

	contact.innerHTML = "";
	contact.appendChild(contents);

	saveButtons();
}

function addRow(template, selector) {
	console.log('hello');
	var template = document.getElementById(template);
	var contents = document.importNode(template.content, true);

	var table = document.querySelector(selector);
	table.appendChild(contents);
	saveButtons();

}

function saveButtons() {
	//Save buttons
	var savebuttons = document.getElementsByClassName('save');
	console.log(savebuttons);
	for(var i=0; i < savebuttons.length; i++) {
		savebuttons[i].onclick = function() {
			alert('pressed!');
		};
	}
}

function showFront(json) {
			json = json[0];
			document.getElementById('fullname').textContent=json.Fullname;
			document.getElementById('profession')
			.textContent=json.Profession;
			document.getElementById('frontpicture')
				.setAttribute('src', json.FrontPicture);
}

function showAbout(json) {
			json = json[0];
			document.getElementById('aboutheading').textContent=json.Heading;
			document.getElementById('aboutdescription')
			.innerHTML=json.Description;
			document.getElementById('aboutimg')
				.setAttribute('src', json.AboutPicture);
		}

function showSkills(json) {
	var id = document.getElementById('sklsdiv');
	var table = id.getElementsByTagName('table')[0];
	var template = document.getElementById('skillsrow');

	for(var i = 0; i < json.length; i++) {
		var row = document.importNode(template.content, true);
		row.querySelector('.skillsname').textContent
		= json[i].Name;
		
		var bar = row.querySelector('.skillsbarvalue');
		bar.setAttribute('class', 'skillsbarvalue value-'
			+ json[i].SkillLevel);
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
		pictureArea.appendChild(clone);

	}



}