HTTP-Pyyntö|Polku|Data|Vastaus 

GET|/cv/front|{'fullname': '', 
'profession': '', 
'picture': 'https://example.com/image.jpg'} 

 PUT|/cv/front/|{'fullname': 'Jane Doe', 
'profession': 'developer', 
'picture': 'https://example.com/image2.jpg'} 

|{'message':'success'} tai {'message':'error'} 

 

GET|/cv/about/||{'picture': 'https://... ', 'heading': '', 'description': 'HTML code'} 

GET|/cv/skills/||{[ 
{'id': 0, 'skill': 'HTML5', 'level': 5}, 
{'id': 1, 'skill': 'CSS3', 'level': 6 
]} 

PUT|/cv/skills/|{'skill': 'PHP', 'level': 3},|{'message':'success'} tai {'message': 'error'} 

DELETE|/cv/skills/{id}||{'message':'success'} tai {'message':'error'} 

 

GET|/cv/experience/||{[ 
{'id': 1, 'year': 2018, 'title': '', 'company': 'Rovio', 'description': '', 'project_id': 2}, 
{'year':0, 'title....'} 
]} 

PUT|/cv/experience/|{'id': 1, 'year': 2018, 'title': '', 'company': 'Rovio', 'description': '', 'project_id': 2},|{'message':'success'} tai {'message':'error'} 

DELETE|/cv/experience/1||{'message':'success'} tai {'message': 'error'} 

GET|/cv/education/||{[ 
{'year': 2017, 'degree': '', 'title': '', 'academy': '', 'description':''}, 
{...}, 
{...} 
]} 

PUT|/cv/education|| 

DELETE|/cv/education/{id}|| 

GET|/portfolio/||{['id': 0, 'name': 'projekti 1', 'desription':'', 'picture': 'https://...'}, 
{...}, 
{...} 
]} 

GET|/portfolio/{id}||{'name':'', 'description': '', 'long_description':'HTML code ', 'picture': 'https://...', 'git_link': 'https://...', 'link', ' git_link’:’https://...’, link _type':'github|gitlab'} 

PUT|/portfolio/{id}|{'name':'', 'description': '', 'long_description': 'HTML code', 'picture': 'https://... ', 'git_link': 'https://... ', 'link_type': 'gitlab'} 

|{'message':'success'} tai {'message': 'error'} 

 

DELETE|/portfolio/{id}|| 

||| 