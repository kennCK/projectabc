// src/auth/index.js
import {router} from '../../router/index'
import ROUTER from '../../router'
import {Howl} from 'howler'
import Vue from 'vue'
export default {
  user: {
    userID: 0,
    username: '',
    type: null,
    status: null,
    profile: null,
    cart: 0,
    notifications: {
      data: null,
      current: null,
      prevCurrent: null
    }
  },
  timer: {
    interval: null,
    speed: 1000
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
  currentPath: false,
  setUser(userID, username, type, status, profile, checkout){
    if(userID === null){
      username = null
      type = null
      status = null
      profile = null
      checkout = 0
    }
    this.user.userID = userID * 1
    this.user.username = username
    this.user.type = type
    this.user.status = status
    this.user.profile = profile
    this.user.checkout = checkout
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
          let profile = response.data[0].account_profile
          let checkout = response.data[0].checkout
          this.setUser(userInfo.id, userInfo.username, userInfo.account_type, userInfo.status, profile, checkout)
          ROUTER.push('/dashboard')
        })
        // this.retrieveNotifications(userInfo.id)
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
          this.setUser(userInfo.id, userInfo.username, userInfo.account_type, userInfo.status, profile, checkout)
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
    this.clearNotifTimer()
    ROUTER.push('/')
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
  }
}
