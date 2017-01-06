var questionLine;
var choiceLine;
var question_counter = 0;

$(document).ready(loadDocument);

function loadDocument() {	

	$("#add_question").click(addQuestion);
	$("#titlebar").keyup(addTitle);
	$("#imagebar").keyup(addImage);
	$("#descbar").keyup(addDesc);
	$("#questionbar").keyup(addQuestionTitle);
	$(".add_choice").click(addChoice);
}

function addChoice(){
	var cid = $(this).attr("id");
	$(this).before('<p><input name="option' + cid + '[]" type="text"  placeholder="Enter Choice"/>' +
						'<a title="Delete Choice" id="' + question_counter + '"class="delete_choice" href="#question_container">AAA</a>' +
						'</p>'); 
	$(".delete_choice").click(deleteChoice);
}

function addQuestion(){
	question_counter++;
	$(".add_choice").unbind();
	$(this).before('<fieldset class="new_question"><legend id="legend_' + question_counter + '">Question ' + question_counter + '</legend>' + 
				   '<p class="questionbar">' + 
				   '<label for="question_title">Question Title</label><br>' + 
				   '<input class="questionbar" type="text" placeholder="Question Title" name="question_title_' + question_counter +'" required><br>' +
				   '</p>' + 
				   '<div class="choice_container">' + 
				   '<p id="' + question_counter + '"class="add_choice"><a title="Add New Choice" href="#question_container"><span><img src="images/add_choice_icon.png" style="width:30px; height:30px"></span></a></p>' + 
				   '</div>' + 
					'<p class="delete_question"><a title="Delete Question" href="#question_container"><span><img src="images/delete_icon.png" style="width:30px; height:30px"></span></a></p>' + 
				   '</fieldset>');
						   
	$(".questionbar").keyup(addQuestionTitle);
	$(".delete_choice").click(deleteChoice);
	$(".delete_question").click(deleteQuestion);
	$(".add_choice").click(addChoice);
}

function addTitle(){
	var title = $("#titlebar").val();
	$("#titlepar>h1").remove();
	$("#titlepar").append('<h1>' + title + '</h1>');
}

function addImage(){
	var imageurl = $("#imagebar").val();
	$("#imagepar>img").remove();
	$("#imagepar").append('<img src="' + imageurl + '" alt = "Poll Image" style="width:304px; height:228px">');
}

function addDesc(){
	var title = $("#descbar").val();
	$("#descpar>h2").remove();
	$("#descpar").append('<h2>' + title + '</h2>');
}

function addQuestionTitle(){
	var title = $("#questionbar").val();
	$("#questionpar>h3").remove();
	$("#questionpar").append('<h3>' + title + '</h3>');
}

function deleteChoice(){
	$(this).closest("p").remove();
}

function deleteQuestion(){
	var id = $(this).attr("id");
	for(var i = id; i < question_counter; i++)
	{
		alert();
		$("legend_" + i).val() = "legend_" + i - 1;
	}
	$(this).closest(".new_question").remove();
}
