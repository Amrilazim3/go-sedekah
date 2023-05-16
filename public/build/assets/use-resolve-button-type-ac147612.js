import{N as v,O as j,F as O,M as E,K as A,d as k,p as $,G as P}from"./app-c6a94172.js";function g(e,t,...n){if(e in t){let a=t[e];return typeof a=="function"?a(...n):a}let r=new Error(`Tried to handle "${e}" but there is no handler defined. Only defined handlers are: ${Object.keys(t).map(a=>`"${a}"`).join(", ")}.`);throw Error.captureStackTrace&&Error.captureStackTrace(r,g),r}var S=(e=>(e[e.None=0]="None",e[e.RenderStrategy=1]="RenderStrategy",e[e.Static=2]="Static",e))(S||{}),T=(e=>(e[e.Unmount=0]="Unmount",e[e.Hidden=1]="Hidden",e))(T||{});function B({visible:e=!0,features:t=0,ourProps:n,theirProps:r,...a}){var i;let l=D(r,n),u=Object.assign(a,{props:l});if(e||t&2&&l.static)return h(u);if(t&1){let o=(i=l.unmount)==null||i?0:1;return g(o,{[0](){return null},[1](){return h({...a,props:{...l,hidden:!0,style:{display:"none"}}})}})}return h(u)}function h({props:e,attrs:t,slots:n,slot:r,name:a}){var i;let{as:l,...u}=H(e,["unmount","static"]),o=(i=n.default)==null?void 0:i.call(n,r),d={};if(r){let f=!1,c=[];for(let[s,p]of Object.entries(r))typeof p=="boolean"&&(f=!0),p===!0&&c.push(s);f&&(d["data-headlessui-state"]=c.join(" "))}if(l==="template"){if(o=m(o??[]),Object.keys(u).length>0||Object.keys(t).length>0){let[f,...c]=o??[];if(!R(f)||c.length>0)throw new Error(['Passing props on "template"!',"",`The current component <${a} /> is rendering a "template".`,"However we need to passthrough the following props:",Object.keys(u).concat(Object.keys(t)).sort((s,p)=>s.localeCompare(p)).map(s=>`  - ${s}`).join(`
`),"","You can apply a few solutions:",['Add an `as="..."` prop, to ensure that we render an actual element instead of a "template".',"Render a single element as the child so that we can forward the props onto that element."].map(s=>`  - ${s}`).join(`
`)].join(`
`));return v(f,Object.assign({},u,d))}return Array.isArray(o)&&o.length===1?o[0]:o}return j(l,Object.assign({},u,d),{default:()=>o})}function m(e){return e.flatMap(t=>t.type===O?m(t.children):[t])}function D(...e){if(e.length===0)return{};if(e.length===1)return e[0];let t={},n={};for(let r of e)for(let a in r)a.startsWith("on")&&typeof r[a]=="function"?(n[a]!=null||(n[a]=[]),n[a].push(r[a])):t[a]=r[a];if(t.disabled||t["aria-disabled"])return Object.assign(t,Object.fromEntries(Object.keys(n).map(r=>[r,void 0])));for(let r in n)Object.assign(t,{[r](a,...i){let l=n[r];for(let u of l){if(a instanceof Event&&a.defaultPrevented)return;u(a,...i)}}});return t}function H(e,t=[]){let n=Object.assign({},e);for(let r of t)r in n&&delete n[r];return n}function R(e){return e==null?!1:typeof e.type=="string"||typeof e.type=="object"||typeof e.type=="function"}let U=0;function C(){return++U}function F(){return C()}var L=(e=>(e.Space=" ",e.Enter="Enter",e.Escape="Escape",e.Backspace="Backspace",e.Delete="Delete",e.ArrowLeft="ArrowLeft",e.ArrowUp="ArrowUp",e.ArrowRight="ArrowRight",e.ArrowDown="ArrowDown",e.Home="Home",e.End="End",e.PageUp="PageUp",e.PageDown="PageDown",e.Tab="Tab",e))(L||{});function y(e){var t;return e==null||e.value==null?null:(t=e.value.$el)!=null?t:e.value}let w=Symbol("Context");var M=(e=>(e[e.Open=0]="Open",e[e.Closed=1]="Closed",e))(M||{});function G(){return N()!==null}function N(){return E(w,null)}function K(e){A(w,e)}function b(e,t){if(e)return e;let n=t??"button";if(typeof n=="string"&&n.toLowerCase()==="button")return"button"}function V(e,t){let n=k(b(e.value.type,e.value.as));return $(()=>{n.value=b(e.value.type,e.value.as)}),P(()=>{var r;n.value||!y(t)||y(t)instanceof HTMLButtonElement&&!((r=y(t))!=null&&r.hasAttribute("type"))&&(n.value="button")}),n}export{T as O,B as P,S as R,L as a,V as b,K as c,G as f,M as l,y as o,N as p,F as t,g as u,H as w};