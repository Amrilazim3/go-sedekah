import{o as i,e as r,a as e,F as x,i as b,t as s,c as m,w as o,b as n,h as a,T as _,n as u,f as c}from"./app-c6a94172.js";import{S as f,b as w,M as y,g as v}from"./menu-5c96761d.js";function k(p,l){return i(),r("svg",{xmlns:"http://www.w3.org/2000/svg",viewBox:"0 0 20 20",fill:"currentColor","aria-hidden":"true"},[e("path",{d:"M10 3a1.5 1.5 0 110 3 1.5 1.5 0 010-3zM10 8.5a1.5 1.5 0 110 3 1.5 1.5 0 010-3zM11.5 15.5a1.5 1.5 0 10-3 0 1.5 1.5 0 003 0z"})])}const C={class:"flex flex-col overflow-hidden"},$={class:"overflow-x-auto sm:-mx-6 lg:-mx-8"},R={class:"inline-block min-w-full sm:px-6 lg:px-8"},q={class:"overflow-hidden"},M={class:"min-w-full"},N={class:"border-b"},z={key:0},A={key:0,class:"bg-white border-b"},B={class:"text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap"},Y={class:"text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap"},S={class:"text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap"},V={class:"px-1 py-1"},j=["onClick"],T={class:"px-1 py-1"},F=["onClick"],E=["onClick"],L={class:"px-1 py-1"},O=["onClick"],G={key:1,class:"bg-white border-b"},H={class:"text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap"},I={class:"text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap"},J={class:"text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap"},K={class:"text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap"},P={class:"py-4 px-6 whitespace-nowrap"},Q={class:"flex space-x-2 text-sm font-semibold"},U=["onClick"],W={key:0,class:"bg-white border-b"},X={class:"text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap"},Z={class:"text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap"},D={class:"text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap"},ee={class:"text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap"},te={class:"text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap"},se={class:"text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap"},oe=["href"],ae={key:1,class:"bg-white border-b"},ie={class:"text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap"},ne={class:"text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap"},re={class:"text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap"},le={class:"text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap"},ce={class:"text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap"},de={class:"text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap"},pe={key:2,class:"bg-white border-b"},ue={class:"text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap"},he={class:"text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap"},me={class:"text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap"},ye={class:"text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap"},ge={class:"text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap"},xe={class:"text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap"},_e={class:"px-1 py-1"},fe=["onClick"],we=["onClick"],ve={key:1,class:"mt-2 text-md px-2 whitespace-nowrap"},$e={__name:"DataTable",props:{headerData:Array,bodyData:Object||Array,type:String},emits:["removeAdmin","approveAdmin","approveNeedy","removeNeedy","deleteBank","viewDonationRequest","deleteDonationRequest","clearRejectedRequest"],setup(p){return(l,ke)=>(i(),r("div",C,[e("div",$,[e("div",R,[e("div",q,[e("table",M,[e("thead",N,[e("tr",null,[(i(!0),r(x,null,b(p.headerData,t=>(i(),r("th",{key:t,scope:"col",class:"text-sm font-semibold whitespace-nowrap text-gray-700 bg-gray-100 px-6 py-4 text-left"},s(t),1))),128))])]),p.bodyData.length>0?(i(),r("tbody",z,[(i(!0),r(x,null,b(p.bodyData,(t,g)=>(i(),r(x,{key:t.id},[l.route().current("admin.users.index")?(i(),r("tr",A,[e("td",B,s(t.name),1),e("td",Y,s(t.email),1),e("td",S,[p.type=="admin"&&l.$page.props.user.email=="go.sedekah0711@gmail.com"&&t.email!="go.sedekah0711@gmail.com"?(i(),m(a(v),{key:0},{default:o(()=>[n(a(f),null,{default:o(()=>[n(a(k),{class:"h-5 w-5 cursor-pointer"})]),_:1}),n(_,{"enter-active-class":"transition duration-100 ease-out","enter-from-class":"transform scale-95 opacity-0","enter-to-class":"transform scale-100 opacity-100","leave-active-class":"transition duration-75 ease-in","leave-from-class":"transform scale-100 opacity-100","leave-to-class":"transform scale-95 opacity-0"},{default:o(()=>[n(a(w),{class:"md:absolute z-40 mt-1 origin-top-left divide-y divide-gray-100 rounded-md bg-white shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none"},{default:o(()=>[e("div",V,[n(a(y),null,{default:o(({active:d})=>[e("button",{class:u([d?"bg-indigo-500 text-white":"text-gray-900","group flex w-full items-center rounded-md px-2 py-2 text-sm"]),onClick:h=>l.$emit("removeAdmin",t.id)}," Remove from admin ",10,j)]),_:2},1024)])]),_:2},1024)]),_:2},1024)]),_:2},1024)):c("",!0),p.type=="donor"?(i(),m(a(v),{key:1},{default:o(()=>[n(a(f),null,{default:o(()=>[n(a(k),{class:"h-5 w-5 cursor-pointer"})]),_:1}),n(_,{"enter-active-class":"transition duration-100 ease-out","enter-from-class":"transform scale-95 opacity-0","enter-to-class":"transform scale-100 opacity-100","leave-active-class":"transition duration-75 ease-in","leave-from-class":"transform scale-100 opacity-100","leave-to-class":"transform scale-95 opacity-0"},{default:o(()=>[n(a(w),{class:"md:absolute z-40 mt-1 origin-top-left divide-y divide-gray-100 rounded-md bg-white shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none"},{default:o(()=>[e("div",T,[l.$page.props.user.email=="go.sedekah0711@gmail.com"?(i(),m(a(y),{key:0},{default:o(({active:d})=>[e("button",{class:u([d?"bg-indigo-500 text-white":"text-gray-900","group flex w-full items-center rounded-md px-2 py-2 text-sm"]),onClick:h=>l.$emit("approveAdmin",t.id)}," Approve to admin ",10,F)]),_:2},1024)):c("",!0),n(a(y),null,{default:o(({active:d})=>[e("button",{class:u([d?"bg-indigo-500 text-white":"text-gray-900","group flex w-full items-center rounded-md px-2 py-2 text-sm"]),onClick:h=>l.$emit("approveNeedy",t.id)}," Approve to needy ",10,E)]),_:2},1024)])]),_:2},1024)]),_:2},1024)]),_:2},1024)):c("",!0),p.type=="needy"?(i(),m(a(v),{key:2},{default:o(()=>[n(a(f),null,{default:o(()=>[n(a(k),{class:"h-5 w-5 cursor-pointer"})]),_:1}),n(_,{"enter-active-class":"transition duration-100 ease-out","enter-from-class":"transform scale-95 opacity-0","enter-to-class":"transform scale-100 opacity-100","leave-active-class":"transition duration-75 ease-in","leave-from-class":"transform scale-100 opacity-100","leave-to-class":"transform scale-95 opacity-0"},{default:o(()=>[n(a(w),{class:"md:absolute z-40 mt-1 origin-top-left divide-y divide-gray-100 rounded-md bg-white shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none"},{default:o(()=>[e("div",L,[n(a(y),null,{default:o(({active:d})=>[e("button",{class:u([d?"bg-indigo-500 text-white":"text-gray-900","group flex w-full items-center rounded-md px-2 py-2 text-sm"]),onClick:h=>l.$emit("removeNeedy",t.id)}," Remove from needy ",10,O)]),_:2},1024)])]),_:2},1024)]),_:2},1024)]),_:2},1024)):c("",!0)])])):c("",!0),l.route().current("needy.banks.index")?(i(),r("tr",G,[e("td",H,s(g+1),1),e("td",I,s(t.name_on_card),1),e("td",J,s(t.account_number),1),e("td",K,s(t.ic_number),1),e("td",P,[e("div",Q,[e("button",{class:"px-3 py-1 bg-gray-50 hover:bg-gray-100 rounded-md text-red-500",onClick:d=>l.$emit("deleteBank",t.id)}," delete ",8,U)])])])):c("",!0),l.route().current("donations.index")?(i(),r(x,{key:2},[p.type=="histories"?(i(),r("tr",W,[e("td",X,s(g+1),1),e("td",Z,s(t.donation_request.user.name),1),e("td",D,s(t.donation_request.title),1),e("td",ee,s(t.amount)+" MYR ",1),e("td",te,s(t.created_at),1),e("td",se,[e("a",{href:t.bill_url,target:"_blank",class:"text-indigo-500 px-3 py-1.5 rounded-md bg-gray-100"}," view ",8,oe)])])):c("",!0),p.type=="user-histories"?(i(),r("tr",ae,[e("td",ie,s(g+1),1),e("td",ne,s(t.user.name),1),e("td",re,s(t.donation_request.user.name),1),e("td",le,s(t.donation_request.title),1),e("td",ce,s(t.amount)+" MYR ",1),e("td",de,s(t.created_at),1)])):c("",!0),p.type=="needy-requests"?(i(),r("tr",pe,[e("td",ue,s(g+1),1),e("td",he,s(t.title),1),e("td",me,s(t.progress)+" ("+s(t.currently_received)+" MYR / "+s(t.target_amount)+" MYR) ",1),e("td",{class:u(["text-sm font-light px-6 py-4 whitespace-nowrap",t.status=="pending"?"text-orange-500":t.status=="approved"?"text-indigo-500":"text-red-500"])},s(t.status),3),e("td",ye,s(t.created_at),1),e("td",{class:u(["text-sm font-light px-6 py-4 whitespace-nowrap",t.is_verified?"text-green-500":"text-red-500"])},s(t.is_verified?"Yes":"No"),3),e("td",ge,s(t.verification_expiry_at?t.verification_expiry_at:"No expiry date yet"),1),e("td",xe,[t.status!="rejected"?(i(),m(a(v),{key:0},{default:o(()=>[n(a(f),null,{default:o(()=>[n(a(k),{class:"h-5 w-5 cursor-pointer"})]),_:1}),n(_,{"enter-active-class":"transition duration-100 ease-out","enter-from-class":"transform scale-95 opacity-0","enter-to-class":"transform scale-100 opacity-100","leave-active-class":"transition duration-75 ease-in","leave-from-class":"transform scale-100 opacity-100","leave-to-class":"transform scale-95 opacity-0"},{default:o(()=>[n(a(w),{class:"xl:absolute z-40 mt-1 origin-top-left divide-y divide-gray-100 rounded-md bg-white shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none"},{default:o(()=>[e("div",_e,[n(a(y),null,{default:o(({active:d})=>[e("div",null,[t.status=="approved"?(i(),r("button",{key:0,class:u([d?"bg-indigo-500 text-white":"text-gray-900","group flex w-full items-center rounded-md px-2 py-2 text-sm"]),onClick:h=>l.$emit("viewDonationRequest",t.id)}," View More ",10,fe)):c("",!0),t.status=="pending"?(i(),r("button",{key:1,class:u([d?"bg-red-500 text-gray-900":"text-gray-900","group flex w-full items-center rounded-md px-2 py-2 text-sm"]),onClick:h=>l.$emit("deleteDonationRequest",t.id)}," Delete ",10,we)):c("",!0)])]),_:2},1024)])]),_:2},1024)]),_:2},1024)]),_:2},1024)):c("",!0)])])):c("",!0)],64)):c("",!0)],64))),128))])):(i(),r("h3",ve," No result "))])])])])]))}};export{$e as _};
