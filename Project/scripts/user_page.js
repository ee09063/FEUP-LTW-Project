
window.addEventListener("load", function() {
	setUp();
}, true);

function setUp()
{
	var text = document.getElementById("searchUserPolls");
	var text2 = document.getElementById("searchAllPolls");
	var text3 = document.getElementById("searchAnsweredPolls");
	
	text.addEventListener("keyup", searchChanged, false);
	text2.addEventListener("keyup", searchAllChanged, false);
	text3.addEventListener("keyup", searchAnsweredChanged, false);
	
}

function searchChanged(event)
{
		var text = event.target;
		var request = new XMLHttpRequest();
		request.addEventListener("load", userPollsReceived, false);
		request.open("GET", "get_user_polls.php?title=" + text.value + "&id=" + userid, true);
		request.send();
}

function userPollsReceived()
{
	var polls = JSON.parse(this.responseText);
	var list = document.getElementById("pollList");
	list.innerHTML = ""; //clean 
	if(polls.length == 0)
	{
		list.innerHTML = "No Results Found"; //clean
	}
	else
	{
		for(poll in polls)
		{
			var paragraph = document.createElement("p");
			paragraph.className = "pollItem";
			var item = document.createElement("a");
			item.className="poll_link";
			var createAText = document.createTextNode(polls[poll].title);
			item.setAttribute('href', "poll_item.php?id=" + polls[poll].id);
			item.appendChild(createAText);
			paragraph.appendChild(item);
			
			var delete_button = document.createElement("a");
			delete_button.setAttribute('id', "delete_button");
			delete_button.setAttribute('href', "delete_poll.php?id=" + polls[poll].id);
			paragraph.appendChild(delete_button);
			
			/**/
			var pbutton = document.createElement("a");
			if(polls[poll].privateStatus == 1)
			{
				pbutton.setAttribute('id', "public_button");
				pbutton.setAttribute('href', "change_private_status.php?id=" + polls[poll].id + "&privateStatus=1");
				var pbuttonText = document.createTextNode("Public Poll");
				pbutton.appendChild(pbuttonText);
			}
			else if(polls[poll].privateStatus == 0)
			{
				pbutton.setAttribute('id', "private_button");
				pbutton.setAttribute('href', "change_private_status.php?id=" + polls[poll].id + "&privateStatus=0");
				var pbuttonText = document.createTextNode("Private Poll");
				pbutton.appendChild(pbuttonText);
			}
			paragraph.appendChild(pbutton);
			
			/**/
			var lbutton = document.createElement("a");
			if(polls[poll].locked == 1)
			{
				lbutton.setAttribute('id', "unlock_button");
				lbutton.setAttribute('href', "change_locked_status.php?id=" + polls[poll].id + "&lockedStatus=1");
				var lbuttonText = document.createTextNode("Unlock Poll");
				lbutton.appendChild(lbuttonText);
			}
			else if(polls[poll].locked == 0)
			{
				lbutton.setAttribute('id', "lock_button");
				lbutton.setAttribute('href', "change_locked_status.php?id=" + polls[poll].id + "&lockedStatus=1");
				var lbuttonText = document.createTextNode("Lock Poll");
				lbutton.appendChild(lbuttonText);
			}
			paragraph.appendChild(lbutton);
			
			list.appendChild(paragraph);
		}
	}
}

function searchAllChanged(event)
{
	var text = event.target;

	var request = new XMLHttpRequest();
	request.addEventListener("load", allPollsReceived, false);
	request.open("GET", "get_user_polls.php?title=" + text.value, true);
	request.send();
}

function allPollsReceived()
{
	var polls = JSON.parse(this.responseText);
	var list = document.getElementById("searchPollsList");
	list.innerHTML = ""; //clean
	if(polls.length == 0)
	{
		list.innerHTML = "No Results Found"; //clean
	}
	else
	{
		for(poll in polls)
		{
			var paragraph = document.createElement("p");
			var item = document.createElement("a");
			var createAText = document.createTextNode(polls[poll].title);
			item.setAttribute('href', "poll_item.php?id=" + polls[poll].id);
			item.appendChild(createAText);
			paragraph.appendChild(item);
			list.appendChild(paragraph);
		}
	}
}


function searchAnsweredChanged(event)
{
	var text = event.target;

	var request = new XMLHttpRequest();
	request.addEventListener("load", answeredPollsReceived, false);
	request.open("GET", "get_user_polls.php?title=" + text.value + "&id=" + userid + "&answer=1", true);
	request.send();
}

function answeredPollsReceived()
{
	var polls = JSON.parse(this.responseText);
	var list = document.getElementById("searchAnsweredPollsList");
	list.innerHTML = ""; //clean 
	if(polls.length == 0)
	{
		list.innerHTML = "No Results Found"; //clean
	}
	else
	{
		for(poll in polls)
		{
			var paragraph = document.createElement("p");
			var item = document.createElement("a");
			var createAText = document.createTextNode(polls[poll].title);
			item.setAttribute('href', "poll_item.php?id=" + polls[poll].id);
			item.appendChild(createAText);
			paragraph.appendChild(item);
			list.appendChild(paragraph);
		}
	}
}








