import{d as s,p as n,o as l,e as i}from"./app-33390a1a.js";const d=["value"],m={__name:"TextAreaInput",props:{modelValue:String},emits:["update:modelValue"],setup(t,{expose:u}){const e=s(null);return n(()=>{e.value.hasAttribute("autofocus")&&e.value.focus()}),u({focus:()=>e.value.focus()}),(a,o)=>(l(),i("textarea",{ref_key:"input",ref:e,class:"border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm",id:"exampleFormControlTextarea1",rows:"3",value:t.modelValue,onInput:o[0]||(o[0]=r=>a.$emit("update:modelValue",r.target.value))},null,40,d))}};export{m as _};
