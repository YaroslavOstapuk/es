(window.webpackJsonp=window.webpackJsonp||[]).push([[9],{94:function(e,r,t){"use strict";t.r(r);var n=t(0),o=t.n(n),a=t(1);function s(e,r){var t=Object.keys(e);if(Object.getOwnPropertySymbols){var n=Object.getOwnPropertySymbols(e);r&&(n=n.filter((function(r){return Object.getOwnPropertyDescriptor(e,r).enumerable}))),t.push.apply(t,n)}return t}function c(e){for(var r=1;r<arguments.length;r++){var t=null!=arguments[r]?arguments[r]:{};r%2?s(Object(t),!0).forEach((function(r){i(e,r,t[r])})):Object.getOwnPropertyDescriptors?Object.defineProperties(e,Object.getOwnPropertyDescriptors(t)):s(Object(t)).forEach((function(r){Object.defineProperty(e,r,Object.getOwnPropertyDescriptor(t,r))}))}return e}function i(e,r,t){return r in e?Object.defineProperty(e,r,{value:t,enumerable:!0,configurable:!0,writable:!0}):e[r]=t,e}function u(e,r,t,n,o,a,s){try{var c=e[a](s),i=c.value}catch(e){return void t(e)}c.done?r(i):Promise.resolve(i).then(n,o)}function l(e){return function(){var r=this,t=arguments;return new Promise((function(n,o){var a=e.apply(r,t);function s(e){u(a,n,o,s,c,"next",e)}function c(e){u(a,n,o,s,c,"throw",e)}s(void 0)}))}}var p={data:function(){return{loading:!1,form:{name:null,description:null,slug:null,main_photo:null}}},mounted:function(){var e=this;return l(o.a.mark((function r(){var t;return o.a.wrap((function(r){for(;;)switch(r.prev=r.next){case 0:return r.next=2,e.fetchMenuItem();case 2:return e.clearCreateButtonInfo(),e.setAppBarTitle("Редагувати групу"),r.next=6,e.getGroup(e.$route.params.slug);case 6:t=r.sent,e.form.name=t.data.name,e.form.description=t.data.description,e.form.slug=t.data.slug;case 10:case"end":return r.stop()}}),r)})))()},computed:c({},Object(a.c)({errors:"getCreateGroupErrors"})),methods:c(c(c({},Object(a.b)(["fetchMenuItem","updateGroup","getGroup"])),Object(a.d)(["setAppBarTitle","clearCreateButtonInfo"])),{},{createNewGroup:function(){var e=this;return l(o.a.mark((function r(){var t;return o.a.wrap((function(r){for(;;)switch(r.prev=r.next){case 0:return e.loading=!0,(t=new FormData).append("_method","PUT"),t.append("name",e.form.name?e.form.name:""),t.append("description",e.form.description?e.form.description:""),t.append("slug",e.form.slug?e.form.slug:""),t.append("main_photo",e.form.main_photo?e.form.main_photo:""),r.next=9,e.updateGroup({slug:e.$route.params.slug,data:t});case 9:r.sent,e.loading=!1;case 11:case"end":return r.stop()}}),r)})))()}})},f=t(2),m=Object(f.a)(p,(function(){var e=this,r=e.$createElement,t=e._self._c||r;return t("div",{staticClass:"group"},[t("v-row",[t("v-col",{attrs:{md:"6",cols:"12"}},[t("v-text-field",{attrs:{label:"Назва групи *","error-messages":e.errors?e.errors.name:""},model:{value:e.form.name,callback:function(r){e.$set(e.form,"name",r)},expression:"form.name"}}),e._v(" "),t("v-text-field",{attrs:{label:"Короткий опис групи"},model:{value:e.form.description,callback:function(r){e.$set(e.form,"description",r)},expression:"form.description"}}),e._v(" "),t("v-text-field",{attrs:{label:"Слаг","error-messages":e.errors?e.errors.slug:""},model:{value:e.form.slug,callback:function(r){e.$set(e.form,"slug",r)},expression:"form.slug"}}),e._v(" "),t("v-file-input",{attrs:{accept:"image/*",label:"Фото групи","error-messages":e.errors?e.errors.main_photo:""},model:{value:e.form.main_photo,callback:function(r){e.$set(e.form,"main_photo",r)},expression:"form.main_photo"}}),e._v(" "),t("div",{staticClass:"btn-store d-flex justify-end"},[t("v-btn",{attrs:{tile:"",color:"success",loading:e.loading},on:{click:e.createNewGroup}},[t("v-icon",{attrs:{left:""}},[e._v("\n                        mdi-pencil\n                    ")]),e._v("\n                    Зберігти зміни\n                ")],1)],1)],1)],1)],1)}),[],!1,null,"593cc200",null);r.default=m.exports}}]);