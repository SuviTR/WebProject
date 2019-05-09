const el = $('#app');
const serv = '/api';
var editmode = false;
//All the JSON data will be saved here:
var data = {};

const router = new Router({
	mode: 'history',
})

window.addEventListener('load', app);

function app() {


	router.add('/', () => {
		showTemplate('index');
		showNav();

		getIndexData();
	});

	router.add('/portfolio/(:any)', (id) => {
		showTemplate('project');
		ajaxRequest('/portfolio/' + id, showProject);
	});

	router.add('/login', () => {
		showTemplate('login');
	});

	router.add('/resume', () => {
		showTemplate('resume');
	});

	router.add('/edit', () => {
		showTemplate('index');
		showNav();
		showEditLinks();
	});

	router.navigateTo(window.location.pathname);

}

function showNav() {
	$( '#navbar').show();
	$( '#navbar > a').on('click', (event) => {
		document.getElementsByClassName('active')[0].className="";
		event.target.setAttribute('class', 'active');
	});
}

function hideNav() {
	$( '#navbar').hide();
}

function spaLink(event) {
	event.preventDefault();

	var target = $(event.target).closest('a');

	const href = target.attr('href');
	const path = href;

	hideNav();
	router.navigateTo(path);
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


function printResume() {
    window.print();
}

function toggleEdit() {
	if(editmode) {
		showTemplate('index');
		getIndexData();

		document.getElementById('editpagebutton').textContent = "Edit page";

		editmode = false;
	} else {
		showEditViews();

		document.getElementById('editpagebutton').textContent = "End editing";
		document.getElementsByClassName('contentcv')[0]
			.setAttribute('class', 'contentcvedit');

		editmode = true;
	}
}


function showTemplate(templateName) {
	let template = document.getElementById(templateName);
	let app = document.getElementById('app');
	app.textContent = "";
	app.appendChild(template.content.cloneNode(true));

	$('a.spa').on('click', spaLink);
}

/* Contents functions */
function getIndexData() {
	//If data is empty, fetch stuff via Ajax
	if(Object.entries(data).length === 0 
		&& data.constructor === Object) {
		ajaxRequest('/cv/front', showFront);

		ajaxRequest('/cv/about', showAbout);

		ajaxRequest('/cv/skills', showSkills);

		ajaxRequest('/cv/experience', showExperience);

		ajaxRequest('/cv/education', showEducation);

		ajaxRequest('/portfolio', showPortfolio);

		ajaxRequest('/cv/contact', showContact);
	} else {
		showFront(data.front);
		showAbout(data.about);
		showSkills(data.skills);
		showExperience(data.experience);
		showEducation(data.education);
		showPortfolio(data.portfolio);
		showContact(data.contact);
	}
}

function showEditLinks() {

}

function showEditViews() {

	var template;
	var contents;

	//front
	template = document.getElementById('frontedit');
	contents = document.importNode(template.content, true);
	var front = document.getElementById('frontdiv');
	front.innerHTML = "";
	front.appendChild(contents);

	front.querySelector('[name=Fullname]').value = data.front[0].Fullname;
	front.querySelector('[name=Profession]').value = data.front[0].Profession;
	front.querySelector('[name=FrontPicture]').value
		= data.front[0].FrontPicture;

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
	text.appendChild(contents.querySelector('.aboutcontents'));

	text.querySelector('[name=Heading]').value = data.about[0].Heading;
	text.querySelector('[name=Description]').value = data.about[0].Description;
	text.querySelector('[name=AboutPicture]').value
		= data.about[0].AboutPicture;


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

	contact.innerHTML = "";
	contact.appendChild(contents);

	contact.querySelector('[name=Phone]').value = data.contact[0].Phone;
	contact.querySelector('[name=Mail]').value = data.contact[0].Mail;
	contact.querySelector('[name=Address]').value
		= data.contact[0].Address;
	// contact.querySelector('[name=Name]').value = data.front[0].Name;
	// contact.querySelector('[name=SomeIcon]').value = data.front[0].SomeIcon;


	saveButtons();
}

function addRow(template, selector) {
	var template = document.getElementById(template);
	var contents = document.importNode(template.content, true);

	var table = document.querySelector(selector);
	table.appendChild(contents);
	saveButtons();

}

function saveButtons() {
	//Save buttons
	var savebuttons = document.getElementsByClassName('save');
	for(var i=0; i < savebuttons.length; i++) {
		savebuttons[i].onclick = () => {
			saveData($(event.target).closest('div[id]'));
		}
	}
}

function saveData(div) {
	var toSave = {};
	var inputs = div.find(":input");
	var url;

	for(var i = 0; i < inputs.length; i++) {
		var input = inputs[i];
		if(input.name === "url") {
			url = input.value;
		} else {
			toSave[input.name] = input.value;
		}
	}
	console.log(toSave);
	var dataName = capitalize(div[0].id.replace('div', ""));
	//console.log(showFunction);

	ajaxRequest(url, (json) => {console.log(json)}, 'PUT', toSave);
	data = {};
	// ajaxRequest(url, window[showFunction]);
	toggleEdit();
	router.navigateTo("/");
}

function showFront(json) {
			data.front = json;
			json = json[0];
			document.title = json.Fullname;
			document.getElementById('fullname').textContent=json.Fullname;
			document.getElementById('profession')
			.textContent=json.Profession;
			document.getElementById('frontpicture')
				.setAttribute('src', json.FrontPicture);
}

function showAbout(json) {
			data.about = json;
			json = json[0];
			document.getElementById('aboutheading').textContent=json.Heading;
			document.getElementById('aboutdescription')
			.innerHTML=json.Description;
			document.getElementById('aboutimg')
				.setAttribute('src', json.AboutPicture);
		}

function showSkills(json) {
	data.skills = json;
	var id = document.getElementById('sklsdiv');
	var table = id.getElementsByTagName('table')[0];
	var template = document.getElementById('skillsrow');
	table.textContent="";

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
	data.experience = json;
	var id = document.getElementById('expdiv');
	var table = id.getElementsByTagName('table')[0];
	var template = document.getElementById('exprow');
	table.textContent="";


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
	data.education = json;
	var id = document.getElementById('edudiv');
	var table = id.getElementsByTagName('table')[0];
	var template = document.getElementById('edurow');
	table.textContent="";


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
	data.portfolio = json;
	var id = document.getElementById('portfoliodiv');
	var row = id.getElementsByClassName('row2')[0];
	var template = document.getElementById('portfolioproject');
	row.textContent = "";

	for(var i = 0; i < json.length; i++) {
		var project = document.importNode(template.content, true);

		var link = project.querySelector('a');
		link.setAttribute('href', '/portfolio/' + json[i].PId);
		link.onclick = spaLink;
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
	data.contact = json;
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
	pictureArea.textContent = "";
	for(key in json.Pictures) {
		var clone = imagetag.cloneNode();
		clone.setAttribute('src', json.Pictures[key]);
		pictureArea.appendChild(clone);

	}



}

/* Ajax functions */
function ajaxRequest(address, processingFunction, method = 'GET', data) {
	//Data must be JSON
	var httpRequest = new XMLHttpRequest();
	httpRequest.onreadystatechange = function () {
		if(httpRequest.readyState === XMLHttpRequest.DONE) {
			if(httpRequest.status === 200 ) {
				
				// console.log(httpRequest.responseText);
				var json = JSON.parse(httpRequest.responseText)
				processingFunction(json);
			}
		}
	}

	httpRequest.open(method, serv + address, true);
	httpRequest.send(JSON.stringify(data));
}

/* Helper functions */
function capitalize(string) {
    return string.charAt(0).toUpperCase() + string.slice(1);
}