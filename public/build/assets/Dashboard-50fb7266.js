import{o,e as d,a as t,t as s,g as u,F as p,d as f,c as _,w as r,v,x as y,b as l,h as c,n as b,f as h}from"./app-33390a1a.js";import{_ as $}from"./AppLayout-6147c6d8.js";import{V as D,r as w,X as R,Q as k}from"./disclosure-363ddda3.js";import"./ApplicationMark-562caf83.js";import"./_plugin-vue_export-helper-c27b6911.js";import"./use-resolve-button-type-a1c72f78.js";function g(a,e){return o(),d("svg",{xmlns:"http://www.w3.org/2000/svg",viewBox:"0 0 20 20",fill:"currentColor","aria-hidden":"true"},[t("path",{d:"M6.28 5.22a.75.75 0 00-1.06 1.06L8.94 10l-3.72 3.72a.75.75 0 101.06 1.06L10 11.06l3.72 3.72a.75.75 0 101.06-1.06L11.06 10l3.72-3.72a.75.75 0 00-1.06-1.06L10 8.94 6.28 5.22z"})])}const q=t("div",{class:"py-8"},[t("div",{class:"border-t border-gray-200"})],-1),j=t("h3",{class:"text-lg text-gray-800 font-semibold mb-2"}," Donation Request Summary ",-1),A={class:"space-y-4"},M={class:"sm:flex"},C={class:"sm:flex-1"},N=t("h3",{class:"text-md font-semibold text-indigo-500"}," Donation received total : ",-1),T={class:"text-md"},S={class:"sm:flex-1"},V=t("h3",{class:"text-md font-semibold text-indigo-500"}," Donation request made total : ",-1),B={class:"text-md"},Y={class:"sm:flex"},F={class:"mt-6 sm:-mt-0 sm:last:flex-1"},L=t("h3",{class:"text-md font-semibold text-indigo-500"}," Total donator : ",-1),O={class:"text-md"},P=t("div",{class:"py-8"},[t("div",{class:"border-t border-gray-200"})],-1),G=t("h3",{class:"text-lg text-gray-800 font-semibold mb-2"}," Recent Donation Request ",-1),H={key:0,class:"relative rounded-md shadow-sm"},U={class:"px-4 py-5 bg-indigo-100 rounded-tr-md rounded-tl-md sm:p-6"},W={class:"flex justify-between text-md leading-5 font-medium text-gray-900"},z={class:"text-gray-600 text-sm"},J={class:"mt-2 sm:flex sm:justify-between"},X={class:"sm:flex"},Z={class:"mr-6 text-sm leading-5 text-gray-500"},E=t("h4",{class:"text-gray-700"},"Details",-1),I={class:"mt-4 sm:mt-0 sm:ml-4 sm:flex-shrink-0 sm:flex sm:justify-end"},K=t("dt",{class:"text-sm text-gray-700"}," Current Donation Received ",-1),Q={class:"text-sm leading-5 font-medium text-blue-600"},tt={class:"sm:ml-4"},et=t("dt",{class:"text-sm text-gray-700"}," Donation Goals ",-1),st={class:"text-sm leading-5 font-medium text-green-600"},ot=t("div",{class:"bg-gray-100 rounded-br-md rounded-bl-md px-4 py-4 sm:px-6"},[t("div",{class:"text-sm leading-5"},[t("a",{href:"#",class:"font-medium text-indigo-600 hover:text-indigo-500 transition duration-150 ease-in-out"}," View More ")])],-1),dt={key:1},nt=t("div",{class:"py-8"},[t("div",{class:"border-t border-gray-200"})],-1),at=t("h3",{class:"text-lg text-gray-800 font-semibold"},"Recent Donator",-1),it={key:0,class:"text-gray-800"},lt={key:0,class:"text-indigo-500 font-semibold"},ct={key:1,class:"text-indigo-500 font-semibold"},rt={key:1},mt={__name:"Needy",props:{data:Object},setup(a){const e=a;return(i,n)=>(o(),d(p,null,[q,t("div",null,[j,t("div",A,[t("div",M,[t("div",C,[N,t("h3",T,s(e.data.donationReceivedTotalAmount)+" MYR ",1)]),t("div",S,[V,t("h3",B,s(e.data.donationRequestsMade)+" times ",1)])]),t("div",Y,[t("div",F,[L,t("p",O,s(e.data.totalDonator),1)])])])]),P,t("div",null,[G,e.data.recentDonationRequest?(o(),d("div",H,[t("div",U,[t("div",W,[t("h3",null,s(e.data.recentDonationRequest.title),1),t("h3",z,s(e.data.recentDonationRequest.created_at),1)]),t("div",J,[t("div",X,[t("div",Z,[E,t("p",null,s(e.data.recentDonationRequest.detail),1)])]),t("div",I,[t("dl",null,[K,t("dd",Q,s(e.data.recentDonationRequest.currently_received)+" MYR ",1)]),t("dl",tt,[et,t("dd",st,s(e.data.recentDonationRequest.target_amount),1)])])])]),ot])):(o(),d("h3",dt,"No request is made yet."))]),nt,t("div",null,[at,e.data.recentDonator?(o(),d("p",it,[e.data.recentDonator.is_hidden?(o(),d("span",lt,"Someone")):(o(),d("span",ct,s(e.data.recentDonator.user.name),1)),u(" donated you "+s(e.data.recentDonator.amount)+" MYR ",1)])):(o(),d("h3",rt,"No recent donator."))])],64))}},_t=t("div",{class:"py-8"},[t("div",{class:"border-t border-gray-200"})],-1),ht=t("h3",{class:"text-lg text-gray-800 font-semibold mb-2"}," Donation Summary ",-1),ut={class:"space-y-4"},xt={class:"sm:flex"},gt={class:"sm:flex-1"},pt=t("h3",{class:"text-md font-semibold text-indigo-500"}," Accumulated donation : ",-1),ft={class:"text-md"},vt={class:"mt-6 sm:-mt-0 sm:last:flex-1"},yt=t("h3",{class:"text-md font-semibold text-indigo-500"}," This month accumulated donation : ",-1),bt={class:"text-md"},$t={class:"sm:flex"},Dt={class:"sm:flex-1"},wt=t("h3",{class:"text-md font-semibold text-indigo-500"}," This month total donors : ",-1),Rt={class:"text-md"},kt=t("div",{class:"py-8"},[t("div",{class:"border-t border-gray-200"})],-1),qt=t("h3",{class:"text-lg text-gray-800 font-semibold mb-2"}," Recent Approved Donation Request ",-1),jt={key:0,class:"relative rounded-md shadow-sm"},At={class:"px-4 py-5 bg-indigo-100 rounded-tr-md rounded-tl-md sm:p-6"},Mt={class:"flex items-center justify-between"},Ct={class:"text-md font-semibold leading-5 text-indigo-500"},Nt={class:"mt-2 flex justify-between leading-5"},Tt={class:"text-md font-medium text-gray-900 underline"},St={class:"text-gray-600 text-sm"},Vt={class:"mt-2 sm:flex sm:justify-between"},Bt={class:"sm:flex"},Yt={class:"mr-6 text-sm leading-5 text-gray-500"},Ft=t("h4",{class:"text-gray-700"},"Details",-1),Lt={class:"mt-4 sm:mt-0 sm:ml-4 sm:flex-shrink-0 sm:flex sm:justify-end"},Ot=t("dt",{class:"text-sm text-gray-700"}," Current Donation Received ",-1),Pt={class:"text-sm leading-5 font-medium text-blue-600"},Gt={class:"sm:ml-4"},Ht=t("dt",{class:"text-sm text-gray-700"}," Donation Goals ",-1),Ut={class:"text-sm leading-5 font-medium text-green-600"},Wt={key:1},zt=t("div",{class:"py-8"},[t("div",{class:"border-t border-gray-200"})],-1),Jt=t("h2",{class:"text-lg font-semibold text-gray-800 mb-2"},"Total Users",-1),Xt={class:"bg-gray-100 p-4 rounded-lg shadow-sm"},Zt={class:"flex justify-between items-center mb-4"},Et=t("div",{class:"text-gray-600 font-semibold text-md"},"Admin",-1),It={class:"text-gray-800 font-semibold text-md"},Kt={class:"flex justify-between items-center mb-4"},Qt=t("div",{class:"text-gray-600 font-semibold text-md"},"Donor",-1),te={class:"text-gray-800 font-semibold text-md"},ee={class:"flex justify-between items-center mb-4"},se=t("div",{class:"text-gray-600 font-semibold text-md"},"Needy",-1),oe={class:"text-gray-800 font-semibold text-md"},de={__name:"Admin",props:{data:Object},setup(a){const e=a;return(i,n)=>(o(),d(p,null,[_t,t("div",null,[ht,t("div",ut,[t("div",xt,[t("div",gt,[pt,t("h3",ft,s(e.data.accumulatedDonation)+" MYR ",1)]),t("div",vt,[yt,t("p",bt,s(e.data.thisMonthAccumulatedDonation)+" MYR ",1)])]),t("div",$t,[t("div",Dt,[wt,t("h3",Rt,s(e.data.thisMonthDonors),1)])])])]),kt,t("div",null,[qt,e.data.recentApprovedDonationRequest?(o(),d("div",jt,[t("div",At,[t("div",Mt,[t("div",Ct,s(e.data.recentApprovedDonationRequest.user.name),1)]),t("div",Nt,[t("h3",Tt,s(e.data.recentApprovedDonationRequest.title),1),t("h3",St,s(e.data.recentApprovedDonationRequest.created_at),1)]),t("div",Vt,[t("div",Bt,[t("div",Yt,[Ft,t("p",null,s(e.data.recentApprovedDonationRequest.detail),1)])]),t("div",Lt,[t("dl",null,[Ot,t("dd",Pt,s(e.data.recentApprovedDonationRequest.currently_received),1)]),t("dl",Gt,[Ht,t("dd",Ut,s(e.data.recentApprovedDonationRequest.target_amount),1)])])])])])):(o(),d("h3",Wt,"No approved donation request yet."))]),zt,t("div",null,[Jt,t("div",Xt,[t("div",Zt,[Et,t("div",It,s(e.data.totalUsers.admin),1)]),t("div",Kt,[Qt,t("div",te,s(e.data.totalUsers.donor),1)]),t("div",ee,[se,t("div",oe,s(e.data.totalUsers.needy),1)])])])],64))}},ne=t("h3",{class:"text-lg text-gray-800 font-semibold mb-2"},"Personal",-1),ae={class:"sm:flex"},ie={class:"sm:flex-1"},le=t("h3",{class:"text-md font-semibold text-indigo-500"}," Donated amount total : ",-1),ce={class:"text-md"},re={class:"mt-6 sm:-mt-0 sm:last:flex-1"},me=t("h3",{class:"text-md font-semibold text-indigo-500"}," Your last donation : ",-1),_e={key:0,class:"text-md"},he={class:"text-indigo-500"},ue={key:1},xe={__name:"Donor",props:{data:Object},setup(a){const e=a;return(i,n)=>(o(),d("div",null,[ne,t("div",ae,[t("div",ie,[le,t("h3",ce,s(e.data.totalDonationAmount)+" MYR ",1)]),t("div",re,[me,e.data.recentDonation?(o(),d("h3",_e,[u(s(e.data.recentDonation.created_at)+" - "+s(e.data.recentDonation.amount)+" MYR ",1),t("span",he," ("+s(e.data.recentDonation.donation_request.user.name)+") ",1)])):(o(),d("h3",ue,"No donation made yet."))])])]))}},ge=t("h2",{class:"font-semibold text-xl text-gray-800 leading-tight"}," Dashboard ",-1),pe={class:"py-12"},fe={class:"max-w-7xl mx-auto sm:px-6 lg:px-8"},ve={class:"bg-red-600 p-2 sm:p-4 overflow-hidden mb-10 shadow-lg sm:rounded-lg"},ye={class:"sm:flex sm:justify-between"},be={class:"flex sm:hidden justify-end mb-2"},$e=t("p",{class:"text-white text-md font-semibold"}," For user information, our app only support a payment via online banking. Thank you!. ",-1),De={key:0,class:"bg-green-400 px-4 py-5 overflow-hidden mb-10 shadow-md sm:rounded-lg"},we=t("h2",{class:"text-black text-xl"}," Need financial support? Register now!. ",-1),Re=t("p",{class:"text-gray-700 text-base mt-2"},[u(" If you in need of money help, send us your documents and email it at "),t("a",{href:"https://mail.google.com/mail/u/0/#sent?compose=GTvVlcSGKZckjCHVvHTMBjSxpjBFFbFrgpHMMwCgRSqxPJMfPbnCHtCWPZqThmVLsJRSgkqLRCWXt",class:"text-indigo-600 underline"},"go.sedekah0711@gmail.com"),u(" for us to validate your documents. After all documents provided is valid, we will give you a permission for asking a donation. But foreach donation request, we will give the authorization whether the request that you are making is make sense or not. ")],-1),ke={class:"w-full pt-4"},qe={class:"rounded-md bg-white p-2"},je=t("span",null,"What documents you need to provide?",-1),Ae=t("ul",{class:"list-disc space-y-1"},[t("li",null,"Document 1"),t("li",null,"Document 2"),t("li",null,"Document 3"),t("li",null,"Document 4")],-1),Me={class:"bg-white p-2 sm:p-4 overflow-hidden mb-10 shadow-lg sm:rounded-lg"},Ce={class:"text-lg"},Ne={class:"bg-white p-2 sm:p-4 overflow-hidden shadow-lg sm:rounded-lg"},Le={__name:"Dashboard",props:{dataRoles:Object},setup(a){const e=a,i=f(!0);return(n,m)=>(o(),_($,{title:"Dashboard"},{header:r(()=>[ge]),default:r(()=>[t("div",pe,[t("div",fe,[v(t("div",ve,[t("div",ye,[t("div",be,[l(c(g),{class:"text-black h-5 w-5 bg-gray-50 rounded-md cursor-pointer",onClick:m[0]||(m[0]=x=>i.value=!1)})]),$e,l(c(g),{class:"hidden sm:block self-start text-black h-5 w-5 bg-gray-50 rounded-md cursor-pointer",onClick:m[1]||(m[1]=x=>i.value=!1)})])],512),[[y,i.value]]),!n.$page.props.inertia.user.roles.includes("needy")&&!n.$page.props.inertia.user.roles.includes("admin")?(o(),d("div",De,[we,Re,t("div",ke,[t("div",qe,[l(c(k),null,{default:r(({open:x})=>[l(c(D),{class:"flex w-full justify-between rounded-lg bg-indigo-500 p-2 text-left text-sm font-medium text-white hover:bg-indigo-400 focus:outline-none focus-visible:ring focus-visible:ring-indigo-500 focus-visible:ring-opacity-75"},{default:r(()=>[je,l(c(w),{class:b([x?"":"rotate-180 transform","h-5 w-5 text-white"])},null,8,["class"])]),_:2},1024),l(c(R),{class:"px-6 pt-4 pb-2 text-sm text-gray-700"},{default:r(()=>[Ae]),_:1})]),_:1})])])])):h("",!0),t("div",Me,[t("h2",Ce," Welcome, "+s(n.$page.props.user.name),1)]),t("div",Ne,[n.$page.props.inertia.user.roles.includes("donor")?(o(),_(xe,{key:0,data:e.dataRoles.donor},null,8,["data"])):h("",!0),n.$page.props.inertia.user.roles.includes("admin")?(o(),_(de,{key:1,data:e.dataRoles.admin},null,8,["data"])):h("",!0),n.$page.props.inertia.user.roles.includes("needy")?(o(),_(mt,{key:2,data:e.dataRoles.needy},null,8,["data"])):h("",!0)])])])]),_:1}))}};export{Le as default};
