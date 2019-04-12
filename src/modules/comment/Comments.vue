<template>
    <span class="post-item-comment" v-bind:id="'comment' + payloadValue">
      <span class="comment-item" v-for="commentItem, commentIndex in item" v-if="item !== null">
        <span class="comment-header">
          <img v-bind:src="config.BACKEND_URL + commentItem.account.profile.url" v-if="commentItem.account.profile !== null">
          <i class="fa fa-user-circle" v-else></i>
          <label class="username">{{commentItem.account.username}}</label>
          <label class="comment-date pull-right"> {{commentItem.created_at_human}}</label>
        </span>
        <span class="comment-content">
          <label>
            {{commentItem.text}}
          </label>
        </span>
        <span class="comment-footer">
          <ul class="footer-menu">
            <li v-on:click="newReply(commentIndex)"><i class="fa fa-reply"></i> Reply</li>
          </ul>
        </span>
        <span class="comment-item-reply">
          <span class="reply-item"  v-for="replyItem, replyIndex in commentItem.comment_replies"v-if="commentItem.comment_replies !== null">
            <span class="reply-header">
              <img v-bind:src="config.BACKEND_URL + replyItem.account.profile.url" v-if="replyItem.account.profile !== null">
              <i class="fa fa-user-circle" v-else></i>
              <label class="username">{{replyItem.account.username}}</label>
              <label class="reply-date pull-right"> {{replyItem.created_at_human}}</label>
            </span>
            <span class="reply-content">
              <label>{{replyItem.text}}</label>
            </span>
          </span>
          <span class="new-reply" v-if="commentItem.new_reply_flag === true">
            <img v-bind:src="config.BACKEND_URL + user.profile.url" v-if="user.profile !== null">
            <label v-else>
              <i class="fa fa-user-circle"></i>
            </label>
            <input type="text" class="form-control" placeholder="Write a reply..." v-model="newReplyInput" @keyup.enter="reply(commentItem.id)"/>
          </span>
        </span>
      </span>
      <span class="new-comment">
        <img v-bind:src="config.BACKEND_URL + user.profile.url" v-if="user.profile !== null">
        <label v-else>
          <i class="fa fa-user-circle"></i>
        </label>
        <input type="text" class="form-control" placeholder="Write a comment..." v-model="newCommentInput" @keyup.enter="comment()"/>
      </span>
    </span>
</template>
<style scoped>
.post-item-comment{
  width: 100%;
  float: left;
  min-height: 1px;
  overflow-y: hidden;
}
.post-item-comment .comment-item{
  width: 96%;
  float: left;
  min-height: 10px;
  overflow-y: hidden;
  margin-left: 2%;
  margin-right: 2%;
  text-align: left;
}
.comment-item .comment-content{
  width: 86%;
  float: left;
  margin-left: 7%;
  margin-right: 7%;
  text-align: justify;
}

.comment-item .comment-content label, .reply-content label{
  line-height: 20px;
}
.post-item-comment .new-comment{
  width: 96%;
  float: right;
  height: 45px;
  margin-right: 2%;
  margin-left: 2%;
  line-height: 45px;
}
.new-comment img, .comment-header img, .reply-header img{
  height: 30px;
  width: 30px;
  border-radius: 50%;
  margin-right: 10px;
  float: left;
  margin-top: 5px;
  margin-left: 10px;
}
.new-comment i, .comment-header i{
  font-size: 24px;
  padding-right: 10px;
  float: left;
  line-height: 45px;
}
.comment-header label{
  line-height: 45px;
  margin-bottom: 0px;
}
.new-comment label{
  width: 10%;
  float: left;
  height: 45px;
  text-align: center;
}
.new-comment input{
  width: 90%;
  float: left;
  height: 45px;
}
.comment-date, .reply-date{
  font-size: 12px;
  color: #999;
}
.comment-header, .comment-footer{
  width: 96%;
  float: left;
  height: 45px;
  margin: 0 2% 0 2%;
  font-weight: 525;
  line-height: 45px;
}
.comment-footer .footer-menu{
  padding: 0px;
  list-style: none;
  width: 90%;
  float: left;
  margin-left: 5%;
  height: 45px;
  line-height: 45px;
}
.comment-footer .footer-menu li{
  float: left;
  width: 50%;
  line-height: 45px;
}
.comment-footer .footer-menu li:hover{
  cursor: pointer;
  text-decoration: underline;
}
.comment .footer-menu li i{
  font-size: 16px;
  padding-right: 10px;
}

.reply-header{
  width: 96%;
  float: left;
  height: 45px;
  margin: 0 2% 0 2%;
  font-weight: 525;
}

.reply-header i{
  font-size: 24px;
  float: left;
  line-height: 45px;
  padding-right: 10px;
}

.comment-item-reply{
  width: 90%;
  margin-left: 10%;
  float: left;
}
.comment-item-reply .reply-item{
  width: 100%;
  float: left;
  min-height: 45px;
  overflow-y: hidden;
}
.comment-item-reply .reply-content{
  width: 86%;
  float: left;
  min-height: 10px;
  overflow-y: hidden;
  margin-left: 7%;
  margin-right: 7%;
  margin-bottom: 10px;
  text-align: justify;
}
.comment-item-reply .new-reply{
  width: 100%;
  float: left;
  height: 50px;
}

.new-reply img{
  height: 30px;
  width: 30px;
  border-radius: 50%;
  margin-right: 10px;
  float: left;
  margin-top: 5px;
  margin-left: 10px;
}

.new-reply label{
  width: 10%;
  float: left;
  height: 45px;
}
.new-reply i{
  font-size: 24px;
  float: left;
  line-height: 45px;
}
.new-reply input{
  width: 90%;
  float: left;
  height: 45px;
}
</style>
<script>
import ROUTER from '../../router'
import AUTH from '../../services/auth'
import CONFIG from '../../config.js'
import axios from 'axios'
export default {
  mounted(){
    if(this.load === true){
      this.retrieve()
    }
  },
  data(){
    return {
      user: AUTH.user,
      config: CONFIG,
      errorMessage: null,
      newCommentInput: null,
      newReplyInput: null,
      item: null,
      prevNewCommentIndex: null
    }
  },
  props: ['payloadValue', 'payload', 'load'],
  methods: {
    redirect(parameter){
      ROUTER.push(parameter)
    },
    retrieve(){
      let parameter = {
        condition: [{
          column: 'payload_value',
          clause: '=',
          value: this.payloadValue
        }, {
          column: 'payload',
          clause: '=',
          value: this.payload
        }]
      }
      this.APIRequest('comments/retrieve', parameter).then(response => {
        if(response.data.length > 0){
          this.item = response.data
        }else{
          this.item = null
        }
      })
    },
    comment(){
      if(this.newCommentInput !== '' || this.newCommentInput !== null){
        let parameter = {
          payload: this.payload,
          payload_value: this.payloadValue,
          account_id: this.user.userID,
          text: this.newCommentInput
        }
        this.APIRequest('comments/create', parameter).then(response => {
          if(response.data > 0){
            this.prevNewCommentIndex = null
            this.newCommentInput = null
            this.retrieve()
            this.$parent.retrieve()
          }
        })
      }
    },
    reply(id){
      if(this.newReplyInput !== '' || this.newReplyInput !== null){
        let parameter = {
          comment_id: id,
          account_id: this.user.userID,
          text: this.newReplyInput
        }
        this.APIRequest('comment_replies/create', parameter).then(response => {
          if(response.data > 0){
            this.prevNewCommentIndex = null
            this.retrieve()
            this.$parent.retrieve()
          }
        })
      }
    },
    newReply(index){
      if(this.prevNewCommentIndex === null){
        this.item[index].new_reply_flag = true
        this.prevNewCommentIndex = index
      }else{
        if(this.prevNewCommentIndex !== index){
          this.item[this.prevNewCommentIndex].new_reply_flag = false
          this.item[index].new_reply_flag = true
          this.prevNewCommentIndex = index
        }
      }
    }
  }
}
</script>
