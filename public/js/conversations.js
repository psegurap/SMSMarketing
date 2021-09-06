$(document).ready(function(){

    contacts = new Vue({
        el : '#ChatList-ConversationDetails',
        data : {
            contacts : contacts,
            current_contact : null,
            updated_conversations_length : null
        },
        mounted :  function (){
            var _this = this;
            $('.mail-write-box').on('keydown', function(event) {
                if(event.key === 'Enter') {
                    if ($(this).val() != "") {
                        _this.SendMessage($(this));
                    }
                }
            });
        },
        computed : {
            
        },
        methods: {
            OpenChat : function (contact){
                this.current_contact = contact;
            },
            SendMessage : function (input){

                this.contacts[this.contacts.indexOf(this.current_contact)]['conversations'].length;

                let _this = this;

                let message = input.val();
                input.val('');

                axios.post(homepath + '/campaigns/contact_campaign/send_message', {contact_info : this.current_contact, text_details : message} ).then(function(response){
                    _this.contacts = response.data.contacts;

                    _this.updated_conversations_length =  this.contacts[this.contacts.indexOf(this.current_contact)]['conversations'].length

                    if ($('.chat[data-chat=' + _this.current_contact.id + '] .bubble').length != _this.updated_conversations_length) {
                        Snackbar.show({
                            text: 'There was an error sending your text.',
                            actionTextColor: '#fff',
                            backgroundColor: '#e7515a'
                        });
                        $('.chat[data-chat=' + _this.current_contact.id + '] .bubble.me:last').remove();
                    }else{
                        let getScrollContainer = document.querySelector('.chat-conversation-box');
                        getScrollContainer.scrollTop = getScrollContainer.scrollHeight;
                    }

                }).catch(function(error){
                    if ($('.chat[data-chat=' + _this.current_contact.id + '] .bubble').length != _this.updated_conversations_length) {
                        $('.chat[data-chat=' + _this.current_contact.id + '] .bubble.me:last').remove();
                        Snackbar.show({
                            text: "There was an error sending your text.",
                            actionTextColor: '#fff',
                            backgroundColor: '#e7515a'
                        });
                    }
                    console.log(error);
                });
            }
        }
    });
});