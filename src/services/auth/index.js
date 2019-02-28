// src/auth/index.js
import {router} from '../../router/index'
import ROUTER from '../../router'
import {Howl} from 'howler'
import Vue from 'vue'
export default {
  user: {
    userID: 0,
    username: '',
    email: null,
    type: null,
    status: null,
    profile: null,
    cart: 0,
    plan: null,
    notifications: {
      data: null,
      current: null,
      prevCurrent: null
    },
    notifSetting: null,
    messages: {
      data: null,
      current: 1,
      prevCurrent: null
    }
  },
  messenger: {
    flag: null
  },
  messengerSupport: {
    flag: null
  },
  notifTimer: {
    timer: null,
    speed: 1000
  },
  google: {
    code: null
  },
  tokenData: {
    token: null,
    tokenTimer: false,
    verifyingToken: false
  },
  otpDataHolder: {
    userInfo: null,
    data: null
  },
  currentPath: false,
  setUser(userID, username, email, type, status, profile, checkout, plan, notifSetting){
    if(userID === null){
      username = null
      email = null
      type = null
      status = null
      profile = null
      checkout = 0
      plan = null
      notifSetting = null
    }
    this.user.userID = userID * 1
    this.user.username = username
    this.user.email = email
    this.user.type = type
    this.user.status = status
    this.user.profile = profile
    this.user.checkout = checkout
    this.user.plan = plan
    this.user.notifSetting = notifSetting
    localStorage.setItem('account_id', this.user.userID)
  },
  setToken(token){
    this.tokenData.token = token
    localStorage.setItem('usertoken', token)
    if(token){
      setTimeout(() => {
        let vue = new Vue()
        vue.APIRequest('authenticate/refresh', {}, (response) => {
          this.setToken(response['token'])
        }, (response) => {
          this.deaunthenticate()
        })
      }, 1000 * 60 * 60) // 50min
    }
  },
  authenticate(username, password, callback, errorCallback){
    let vue = new Vue()
    let credentials = {
      username: username,
      password: password,
      status: 'VERIFIED'
    }
    vue.APIRequest('authenticate', credentials, (response) => {
      this.setToken(response.token)
      vue.APIRequest('authenticate/user', {}, (userInfo) => {
        let parameter = {
          'condition': [{
            'value': userInfo.id,
            'clause': '=',
            'column': 'id'
          }]
        }
        vue.APIRequest('accounts/retrieve', parameter).then(response => {
          if(response.data.length > 0){
            this.otpDataHolder.userInfo = userInfo
            this.otpDataHolder.data = response.data
            this.checkOtp(response.data[0].notification_settings)
          }
        })
        // this.retrieveNotifications(userInfo.id)
        this.retrieveMessages(userInfo.id, userInfo.account_type)
        if(callback){
          callback(userInfo)
        }
      })
    }, (response, status) => {
      if(errorCallback){
        errorCallback(response, status)
      }
    })
  },
  checkAuthentication(callback){
    this.tokenData.verifyingToken = true
    let token = localStorage.getItem('usertoken')
    if(token){
      this.setToken(token)
      let vue = new Vue()
      vue.APIRequest('authenticate/user', {}, (userInfo) => {
        let parameter = {
          'condition': [{
            'value': userInfo.id,
            'clause': '=',
            'column': 'id'
          }]
        }
        vue.APIRequest('accounts/retrieve', parameter).then(response => {
          let profile = response.data[0].account_profile
          let checkout = response.data[0].checkout
          let plan = response.data[0].plan
          let notifSetting = response.data[0].notification_settings
          this.setUser(userInfo.id, userInfo.username, userInfo.email, userInfo.account_type, userInfo.status, profile, checkout, plan, notifSetting)
        }).done(response => {
          this.tokenData.verifyingToken = false
          let location = window.location.href
          if(this.currentPath){
            // ROUTER.push(this.currentPath)
          }else{
            window.location.href = location
          }
        })
        // this.retrieveNotifications(userInfo.id)
        this.retrieveMessages(userInfo.id, userInfo.account_type)
      }, (response) => {
        this.setToken(null)
        this.tokenData.verifyingToken = false
        ROUTER.push({
          path: this.currentPath
        })
      })
      return true
    }else{
      this.tokenData.verifyingToken = false
      this.setUser(null)
      return false
    }

  },
  deaunthenticate(){
    localStorage.removeItem('usertoken')
    localStorage.removeItem('account_id')
    this.setUser(null)
    let vue = new Vue()
    vue.APIRequest('authenticate/invalidate')
    this.clearMessenger()
    this.clearNotifTimer()
    this.tokenData.token = null
    ROUTER.go('/')
  },
  retrieveNotifications(accountId){
    let vue = new Vue()
    let parameter = {
      'account_id': accountId
    }
    vue.APIRequest('notifications/retrieve', parameter).then(response => {
      if(response.data.length > 0){
        this.user.notifications.data = response.data
        this.user.notifications.current = response.notification_current
        if(this.user.notifications.current > 0){
          // this.playNotificationSound()
        }
      }else{
        this.user.notifications.data = null
        this.user.notifications.current = null
      }
    })
  },
  retrieveMessages(accountId, type){
    let vue = new Vue()
    let parameter = {
      account_id: accountId,
      account_type: type
    }
    vue.APIRequest('messenger_groups/retrieve_summary', parameter).then(response => {
      this.user.messages.data = response.data
    })
  },
  startNotifTimer(accountId){
    if(this.notifTimer.timer === null){
      this.notifTimer.timer = window.setInterval(() => {
        if(accountId !== null){
          this.retrieveNotifications(accountId)
        }
      }, this.notifTimer.speed)
    }
  },
  clearNotifTimer(){
    if(this.notifTimer.timer !== null){
      window.clearInterval(this.notifTimer.timer)
      this.notifTimer.timer = null
    }
  },
  clearMessenger(){
    if(this.messenger.flag !== null){
      this.messenger.flag = null
    }
  },
  clearMessengerSuuport(){
    if(this.messengerSupport.flag !== null){
      this.messengerSupport.flag = null
    }
  },
  playNotificationSound(){
    let audio = require('../../assets/audio/notification.mp3')
    let sound = new Howl({
      src: [audio]
    })
    if(this.user.notifications.prevCurrent === null){
      sound.play()
      this.user.notifications.prevCurrent = this.user.notifications.current
    }else if(this.user.notifications.prevCurrent < this.user.notifications.current){
      sound.play()
      this.user.notifications.prevCurrent = this.user.notifications.current
    }
  },
  checkPlan(){
    if(this.user.plan !== null){
      if(this.user.plan.title === 'Expired' && this.user.type !== 'ADMIN'){
        ROUTER.push('/plan')
      }
    }
  },
  redirect(path){
    if(path.includes('messenger') === false){
      this.clearMessenger()
    }else{
      this.messenger.flag = true
    }
    ROUTER.push(path)
  },
  validateEmail(email){
    let reg = /^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?(?:\.[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?)*$/
    if(reg.test(email) === false){
      return false
    }else{
      return true
    }
  },
  checkOtp(setting){
    if(setting !== null){
      if(parseInt(setting.email_otp) === 1 || parseInt(setting.sms_otp) === 1){
        // ask otp code here
        $('#otpModal').modal({
          backdrop: 'static',
          keyboard: true,
          show: true
        })
      }else{
        this.proceedToLogin()
      }
    }else{
      this.proceedToLogin()
    }
  },
  proceedToLogin(){
    let userInfo = this.otpDataHolder.userInfo
    let data = this.otpDataHolder.data
    let profile = data[0].account_profile
    let checkout = data[0].checkout
    let plan = data[0].plan
    let notifSetting = data[0].notification_settings
    this.setUser(userInfo.id, userInfo.username, userInfo.email, userInfo.account_type, userInfo.status, profile, checkout, plan, notifSetting)
    ROUTER.push('/templates')
  }
}
