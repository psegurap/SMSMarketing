$(document).ready(function(){

    contacts = new Vue({
        el : '#ChatList-ConversationDetails',
        data : {
            contacts : contacts,
            templates : templates,
            custom_templates : [],
            current_user : current_user,
            current_contact : null,
            updated_conversations_length : null,
            timer : null

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

            $('#templates_select').on('change', function (){
                if ($(this).find(':selected').text() != '') {
                    $('.mail-write-box').val($(this).find(':selected').text());
                    $('#templates_select').val("");
                }
            });

            this.timer = setInterval(this.RefreshConversations, 10000);
        },
        computed : {

        },
        methods: {
            OpenChat : function (event, contact){
                $('.chat-conversation-box').removeClass('ps ps--active-y');
                this.UpdateTemplates(contact);
                var _this = this;
                if ($(event.target).hasClass('person')) {
                    $(event.target).removeClass('unread')
                }else{
                    $(event.target).parents('.person').removeClass('unread');
                }

                this.current_contact = contact;
                
                axios.post(homepath + '/conversations/update_unread', {contact_info : contact} ).then(function(response){
                    _this.contacts = response.data.contacts;
                    _this.RefreshTimer();
                }).catch(function(error){
                    console.log(error);
                });
            },
            SendMessage : function (input){
                let _this = this;
                let message = input.val();
                input.val('');

                axios.post(homepath + '/campaigns/contact_campaign/send_message', {contact_info : this.current_contact, text_details : message} ).then(function(response){
                    _this.contacts = response.data.contacts;
                    _this.updated_conversations_length = _this.contacts.find(contact => contact.id ===  _this.current_contact.id);
                    _this.updated_conversations_length = _this.updated_conversations_length['conversations'].length;
                    _this.RefreshTimer();

                    if ($('.chat[data-chat=' + _this.current_contact.id + '] .bubble').length == _this.updated_conversations_length) {
                        Snackbar.show({
                            text: 'There was an error sending your text.',
                            actionTextColor: '#fff',
                            backgroundColor: '#e7515a'
                        });
                    }else{
                        let getScrollContainer = document.querySelector('.chat-conversation-box');
                        getScrollContainer.scrollTop = getScrollContainer.scrollHeight;
                    }

                }).catch(function(error){
                    if ($('.chat[data-chat=' + _this.current_contact.id + '] .bubble').length == _this.updated_conversations_length) {
                        Snackbar.show({
                            text: "There was an error sending your text.",
                            actionTextColor: '#fff',
                            backgroundColor: '#e7515a'
                        });
                    }
                    console.log(error);
                });
            },
            PropertyInfo: function () {
                window.open(homepath + '/campaigns/propertyinfo/' + this.current_contact.campaign_id + "/" + this.current_contact.id, '_blank');
            },
            ArchiveProperty: function () {
                var _this = this;
                axios.post(homepath + '/campaigns/archive_contact', {contact_info : this.current_contact}).then(function(response){
                    _this.RefreshTimer();
                    _this.contacts = response.data.contacts;
                }).catch(function(error){
                    console.log(error);
                });

                $('.chat-not-selected').css('display', 'flex');
                $('.overlay-phone-call, .overlay-video-call, .chat-box-inner').hide();
                $('.user-list-box .person.active').remove();
            },
            UpdateTemplates :  function (contact) {
                this.custom_templates = [];
                for (let index in templates) {
                    let template_info = templates[index]['template'];
                    
                    template_info = template_info.replace('{contact}', contact.first_name);
                    template_info = template_info.replace('{name}', current_user);
                    template_info = template_info.replace('{address}', contact.property);
                    
                    this.custom_templates.push(template_info);
                }
            },
            RefreshConversations : function () {
                var _this = this;
                axios.post(homepath + '/conversations/refresh_conversations').then(function(response){
                    _this.contacts = response.data.contacts;
                }).catch(function(error){
                    console.log(error);
                });
            },
            RefreshTimer : function () {
                clearInterval(this.timer);
                this.timer = setInterval(this.RefreshConversations, 10000);
            }
        }
    });
});