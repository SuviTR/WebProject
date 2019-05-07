const el = $('#app');
const serv = 'http://vcust539.louhi.net:81';


window.addEventListener('load', app);

function app() {

	const router = new Router({
		mode: 'history',
	})


	router.add('/', () => {
		showTemplate('index');

		getAjaxData('/cv/front', showFront);

		getAjaxData('/cv/about', showAbout);

		getAjaxData('/cv/skills', showSkills);

		getAjaxData('/cv/experience', showExperience);

		getAjaxData('/cv/education', showEducation);

		getAjaxData('/cv/portfolio', showPortfolio);

		getAjaxData('/cv/concact', showContact);
	})

	router.add('/portfolio/project1', () => {
		showTemplate('project');
	});

	router.navigateTo(window.location.pathname);

	const link = $(`a[href$='${window.location.pathname}']`);
	link.addClass('active');

}

/* Contents functions */
function getAjaxData(address, processingFunction) {
	var httpRequest = new XMLHttpRequest();
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

	console.log(template);

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

}

function showContact(json) {
	json = json[0];
	//     $sql = "SELECT Phone, Mail, Address, Name, Link ,SomeIcon FROM 
	var div = document.getElementById('contact');

	contact.getElementById('phone_number').textContent=json.Phone;
	contact.getElementById('email_address').textContent=json.Mail;
	contact.getElementById('street_address').textContent=json.Address;

}