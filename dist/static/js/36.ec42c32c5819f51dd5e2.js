webpackJsonp([36],{1115:function(t,n,i){t.exports={render:function(){var t=this,n=t.$createElement,a=t._self._c||n;return a("div",{staticClass:"row"},[a("div",{staticClass:"col-md-6 col-lg-4 mx-auto signup-container"},[a("div",{staticClass:"login-wrapper"},[a("div",{staticClass:"signup-header",staticStyle:{"margin-top":"50px"}},[a("img",{attrs:{src:i(387)},on:{click:function(n){t.redirect("/")}}})]),t._v(" "),a("span",{staticStyle:{width:"100%",float:"left","text-align":"center","font-size":"20px","margin-bottom":"10px"}},[t._v("\n        Verification\n      ")]),t._v(" "),a("div",{staticClass:"signup-holder"},[a("br"),t._v(" "),a("div",[a("div",{staticClass:"login-spacer",class:{"text-danger":!1===t.flag},staticStyle:{"margin-bottom":"25px !important","text-align":"justify"}},[t._v("\n            "+t._s(t.message)+"\n          ")]),t._v(" "),!1===t.verified?a("button",{staticClass:"btn btn-login-primary btn-block btn-login login-spacer",on:{click:function(n){t.update()}}},[t._v("Continue")]):t._e(),t._v(" "),!0===t.verified&&t.user.userID<=0?a("button",{staticClass:"btn btn-login-danger btn-block btn-login login-spacer",on:{click:function(n){t.redirect("/")}}},[t._v("Back to Login")]):t._e()])])])])])},staticRenderFns:[]}},321:function(t,n,i){i(969);var a=i(113)(i(798),i(1115),"data-v-34b68134",null);t.exports=a.exports},387:function(t,n,i){t.exports=i.p+"static/img/logo.05b476b.png"},798:function(t,n,i){"use strict";Object.defineProperty(n,"__esModule",{value:!0});var a=i(19),e=i(33);n.default={mounted:function(){this.username=this.$route.params.username,this.code=this.$route.params.code,this.retrieveAccount(),this.setMessage(),null!==this.account&&this.validate()},data:function(){return{username:this.$route.params.username,code:this.$route.params.code,account:null,flag:null,message:null,user:e.a.user,verified:!1}},methods:{setMessage:function(){this.message="Hi "+this.username+"! Please click the button to verify your email address here in ClassWorx"},retrieveAccount:function(){var t=this,n={condition:[{column:"username",value:this.username,clause:"="},{column:"code",value:this.code,clause:"="}]};this.APIRequest("accounts/retrieve",n).then(function(n){n.data.length>0?t.account=n.data[0]:t.account=null})},update:function(){var t=this;if(this.retrieveAccount(),!0===this.validate()&&null!==this.account){var n={id:this.account.id,status:"VERIFIED"};this.APIRequest("accounts/update_verification",n).then(function(n){!0===n.data?(t.message="Congratulations! You've have successfully verified your account. Kindly click Continue Button to login.",t.flag=!0,t.verified=!0):(t.flag=!1,t.verified=!1,t.message="Sorry! Internal Error. Kindly verify again or contact the system support.")})}else this.flag=!1,this.message="Sorry! Internal Error. Kindly verify again or contact the system support."},validate:function(){return null!==this.username||null!==this.code?(this.flag=!0,!0):(this.flag=!1,!1)},redirect:function(t){a.a.push(t)}}}},873:function(t,n,i){n=t.exports=i(300)(),n.push([t.i,".signup-container[data-v-34b68134]{margin-top:50px}.signup-header[data-v-34b68134]{height:100px;color:#060;width:100%;float:left;text-align:center}.signup-header img[data-v-34b68134]{height:100px!important;width:100px!important}.signup-header img[data-v-34b68134]:hover{cursor:pointer}.header-title[data-v-34b68134]{width:90%;margin:25px 5% 0;font-size:24px;font-weight:700px}.input-holder[data-v-34b68134]{width:90%;margin:0 5%}.form-control[data-v-34b68134]{height:45px!important}.btn-login-primary[data-v-34b68134]{background:#22b173;color:#fff;height:45px!important}.btn-login-primary[data-v-34b68134]:hover{border:1px solid #3f0050}.btn-login-danger[data-v-34b68134]{background:red;color:#fff;height:45px!important}.btn-login-danger[data-v-34b68134]:hover{border:1px solid #a90201}.input-group[data-v-34b68134]{margin-top:5px;margin-bottom:5px}.site-title[data-v-34b68134]{margin-top:25px;width:100%;float:left}.site-title img[data-v-34b68134]{width:50px;float:left;margin-right:10px}.site-title .app-name[data-v-34b68134]{float:left}@media (max-width:991px){.custom-holder[data-v-34b68134]{box-shadow:0 0 0 0 #fff!important;margin-top:50px!important}}","",{version:3,sources:["C:/xampp/htdocs/projectabc/src/modules/home/LoginByVerification.vue"],names:[],mappings:"AACA,mCACE,eAAiB,CAClB,AACD,gCACE,aAAc,AACd,WAAe,AACf,WAAY,AACZ,WAAY,AACZ,iBAAmB,CACpB,AACD,oCACE,uBAAyB,AACzB,qBAAwB,CACzB,AACD,0CACE,cAAgB,CACjB,AACD,+BACE,UAAW,AACX,iBAAsB,AACtB,eAAgB,AAChB,iBAAmB,CACpB,AACD,+BACE,UAAW,AACX,WAAmB,CACpB,AACD,+BACE,qBAAwB,CACzB,AACD,oCACE,mBAAoB,AACpB,WAAY,AACZ,qBAAwB,CACzB,AACD,0CACE,wBAA0B,CAC3B,AACD,mCACE,eAAoB,AACpB,WAAY,AACZ,qBAAwB,CACzB,AACD,yCACE,wBAA0B,CAC3B,AACD,8BACE,eAAgB,AAChB,iBAAmB,CACpB,AACD,6BACE,gBAAiB,AACjB,WAAY,AACZ,UAAY,CACb,AACD,iCAEE,WAAY,AACZ,WAAY,AACZ,iBAAmB,CACpB,AACD,uCACE,UAAY,CACb,AAED,yBACA,gCACI,kCAAoC,AACpC,yBAA4B,CAC/B,CACA",file:"LoginByVerification.vue",sourcesContent:["\n.signup-container[data-v-34b68134]{\r\n  margin-top: 50px;\n}\n.signup-header[data-v-34b68134]{\r\n  height: 100px;\r\n  color: #006600;\r\n  width: 100%;\r\n  float: left;\r\n  text-align: center;\n}\n.signup-header img[data-v-34b68134]{\r\n  height: 100px !important;\r\n  width: 100px !important;\n}\n.signup-header img[data-v-34b68134]:hover{\r\n  cursor: pointer;\n}\n.header-title[data-v-34b68134]{\r\n  width: 90%;\r\n  margin:  25px 5% 0 5%;\r\n  font-size: 24px;\r\n  font-weight: 700px;\n}\n.input-holder[data-v-34b68134]{\r\n  width: 90%;\r\n  margin:  0 5% 0 5%;\n}\n.form-control[data-v-34b68134]{\r\n  height: 45px !important;\n}\n.btn-login-primary[data-v-34b68134]{\r\n  background: #22b173;\r\n  color: #fff;\r\n  height: 45px !important;\n}\n.btn-login-primary[data-v-34b68134]:hover{\r\n  border: solid 1px #3f0050;\n}\n.btn-login-danger[data-v-34b68134]{\r\n  background: #ff0000;\r\n  color: #fff;\r\n  height: 45px !important;\n}\n.btn-login-danger[data-v-34b68134]:hover{\r\n  border: solid 1px #a90201;\n}\n.input-group[data-v-34b68134]{\r\n  margin-top: 5px;\r\n  margin-bottom: 5px;\n}\n.site-title[data-v-34b68134]{\r\n  margin-top: 25px;\r\n  width: 100%;\r\n  float: left;\n}\n.site-title img[data-v-34b68134]{\r\n  width: 50px;\r\n  width: 50px;\r\n  float: left;\r\n  margin-right: 10px;\n}\n.site-title .app-name[data-v-34b68134]{\r\n  float: left;\n}\r\n/*-------------- Extra Small Screen for Mobile Phones --------------*/\n@media (max-width: 991px){\n.custom-holder[data-v-34b68134]{\r\n    box-shadow: 0 0 0 0 #fff !important;\r\n    margin-top: 50px !important;\n}\n}\r\n"],sourceRoot:""}])},969:function(t,n,i){var a=i(873);"string"==typeof a&&(a=[[t.i,a,""]]),a.locals&&(t.exports=a.locals);i(301)("af507f74",a,!0)}});
//# sourceMappingURL=36.ec42c32c5819f51dd5e2.js.map