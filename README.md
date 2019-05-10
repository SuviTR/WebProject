# Portfolio 
A simple web portfolio.

![A screen capture of the front page](/img/Cv_FrontPage.jpg "A screen capture of the front page")
![A screen capture of the about](/img/Cv_About.jpg "A screen capture of the about")
![A screen capture of the skills](/img/Cv_Skills.jpg "A screen capture of the skills")
![A screen capture of the experience](/img/Cv_Experience.jpg "A screen capture of the experience")
![A screen capture of the portfolio](/img/Cv_Portfolio.jpg "A screen capture of the portfolio")
![A screen capture of the contact](/img/Cv_Contact.jpg "A screen capture of the contact")

## REST API description
| HTTP-Pyyntö | Polku | Data | Vastaus | 
|-------------|-------|------|---------|
| GET | /api/cv/front | | `{    "fullname": "",     "profession": "",<br> "picture": "https://example.com/image.jpg"<br>}` | |
| PUT | /api/cv/front/ | `{"fullname": "Jane Doe",<br> "profession": "developer",<br> "picture": "https://example.com/image2.jpg"}` | `{"message":"success"}` tai `{"message":"error"}` | 
| GET | /api/cv/about/ | | `{"picture": "https://... ",<br> "heading": "",<br> "description": "HTML code"}` | | 
| GET | /api/cv/skills/ | | `{[ {"id": 0, "skill": "HTML5", "level": 5}, {"id": 1, "skill": "CSS3", "level": 6 ]} ` ||
| PUT | /api/cv/skills/ | `{"skill": "PHP", "level": 3}`| `{"message":"success"}` tai `{"message": "error"}` | 
| DELETE|/api/cv/skills/{id}||`{"message":"success"}` tai `{"message":"error"}` 
|GET|/api/cv/experience/| |`{["id": 1, "year": 2018, "title": "", "company": "Rovio", "description": "", "project_id": 2},{"year":0, "title...."}]}` 
|PUT|/api/cv/experience/|`{"id": 1, "year": 2018, "title": "", "company": "Rovio", "description": "", "project_id": 2}`|`{"message":"success"}` tai `{"message":"error"}` 
DELETE|/api/cv/experience/1| |`{"message":"success"}` tai `{"message":"error"}`
GET|/api/cv/education/| |`{[ {"year": 2017, "degree": "", "title": "", "academy": "", "description":""}, {...}, {...} ]}` 
PUT|/api/cv/education|| 
DELETE|/api/cv/education/{id}|| 
GET|/api/portfolio/| |`{["id": 0, "name": "projekti 1", "desription":"", "picture": "https://..."}, {...}, {...} ]} `
GET|/api/portfolio/{id}| |`{"name":"", "description": "", "long_description":"HTML code ", "picture": "https://...", "git_link": "https://...", "link", " git_link’:’https://...’, link _type":"github / gitlab"} `
PUT|/api/portfolio/{id}|`{"name":"", "description": "", "long_description": "HTML code", "picture": "https://... ", "git_link": "https://... ", "link_type": "gitlab"}` |`{"message":"success"}` tai `{"message":"error"}`
DELETE|/api/portfolio/{id}||||| 
POST|/api/login| `{"Username":"janedoe", "Password":"password"}` | `{"Message":"Success"}` or `{"Message":"Error"}`
POST|/api/uploadimage|`FormData("upload", file, file.name)`| `{"Message":"Success"}` or `{"Message":"<Error generated by PHP>"}`