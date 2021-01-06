import $, { valHooks } from 'jquery';

class MyNotes {

    constructor() {
        this.events();
    }

    events() {

        $("#my-notes").on("click", ".delete-note", this.deleteNote);
        $("#my-notes").on("click", ".edit-note", this.editNote.bind(this));
        $("#my-notes").on("click", ".update-note", this.updateNote.bind(this));
        /* $(".delete-note").on("click", this.deleteNote);
        $(".edit-note").on("click", this.editNote.bind(this));
        $(".update-note").on("click", this.updateNote.bind(this)); */
        $(".submit-note").on("click", this.createNote.bind(this));
    }

     // methods go here
     createNote() {

         var NewNote = {
             'title': $(".new-note-title").val(),
             'content': $(".new-note-body").val(),
             'status' : 'publish' // we will change this to private in the server side 
         };

         $.ajax({
             beforeSend: (xhr) => {
                 xhr.setRequestHeader('X-WP-NONCE', universityData.nonce);
             },
             url: universityData.root_url + '/wp-json/wp/v2/note/',
             type: 'POST',
             data: NewNote,
             success: (response) => {
                 $(".new-note-title, .new-note-body").val('');
                 $(`
                    <li data-id="${response.id}">
                    <input readonly class="note-title-field" type="text" value="${response.title.raw}">
                    <span class="edit-note"><i class="fa fa-pencil" aria-hidden="true"></i> Edit</span>
                    <span class="delete-note"><i class="fa fa-trash-o" aria-hidden="true"></i> Delete</span>
                    <textarea readonly class="note-body-field">${response.content.raw}</textarea>
                    <span class="update-note btn btn--blue btn--small"><i class="fa fa-arrow-right" aria-hidden="true"></i> Save</span>
                </li>
                 `).prependTo("#my-notes").hide().slideDown();
                 console.log('Congrats');
                 console.log(response);
             },
             error: (response) => {
                 if (response.responseText == "exceed_limit") {
                     $(".limit-note").html('You have reached the limits of your notes. Please delete some to create new one.');
                 }
                 console.log('Sorry');
                 console.log(response);
             }
         })
     }
     
     editNote(e) {
         var ThisNote = $(e.target).parents("li");
         //if (ThisNote.find(".note-title-field, .note-body-field").attr("readonly")) {
        if (ThisNote.data("state") == "editable") {
            this.makeReadOnlyNote(ThisNote);
         } else {
            this.makeEditableNote(ThisNote);

         }
     }

    makeEditableNote(ThisNote) {
        ThisNote.find(".note-title-field, .note-body-field").removeAttr('readonly').addClass("note-active-field");
        ThisNote.find(".update-note").addClass("update-note--visible");
        ThisNote.find(".edit-note").html('<i class="fa fa-times" aria-hidden="true"></i> Cancel');
        ThisNote.data("state", "editable");
     }

    makeReadOnlyNote(ThisNote) {
         ThisNote.find(".note-title-field, .note-body-field").attr("readonly", "readonly").removeClass("note-active-field");
         ThisNote.find(".update-note").removeClass("update-note--visible");
         ThisNote.find(".edit-note").html('<i class="fa fa-pencel" aria-hidden="true"></i> Edit');
        ThisNote.data("state", "cancel");
     }

    updateNote(e) {

        var ThisNote = $(e.target).parents("li");
        var UpdatedPost = {
            'title' : ThisNote.find(".note-title-field").val(),
            'content': ThisNote.find(".note-body-field").val()
        };

        $.ajax({
            beforeSend: (xhr) => {
                xhr.setRequestHeader('X-WP-NONCE', universityData.nonce);
            },
            url: universityData.root_url + '/wp-json/wp/v2/note/' + ThisNote.data("id"),
            type: 'POST',
            data: UpdatedPost,
            success: (response) => {
                this.makeReadOnlyNote(ThisNote);
                console.log('Congrats');
                console.log(response);
            },
            error: (response) => {
                console.log('Sorry');
                console.log(response);
            }
        })
    }

    deleteNote(e) {
        var ThisNote = $(e.target).parents("li");
       $.ajax({
           beforeSend: (xhr) => {
               // note: XMLHttpRequest (XHR) 
               xhr.setRequestHeader('X-WP-NONCE', universityData.nonce);
           },
           url: universityData.root_url + '/wp-json/wp/v2/note/' + ThisNote.data("id"),
           type: 'DELETE',
           success: (response) => {
               ThisNote.slideUp();
               if (response.userPostsCount < 4) {
                   $(".limit-note").html('');
               }
               
               console.log('Congrats');
               console.log(response);
           },
           error: (response) => {
               console.log('Sorry');
               console.log(response);
           }
       })
    }
   
}

export default MyNotes;