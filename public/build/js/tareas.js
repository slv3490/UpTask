!function(){!async function(){try{const t="/api/tareas?id="+i(),a=await fetch(t),n=await a.json();e=n.tareas,o()}catch(e){console.log(e)}}();let e=[],t=[];document.querySelector("#agregar-tarea").addEventListener("click",()=>{r()});function a(a){const n=a.target.value;t=""!==n?e.filter(e=>e.estado===n):[],o()}document.querySelectorAll("#filtros input[type='radio']").forEach(e=>{e.addEventListener("input",a)});const n={0:"Pendiente",1:"Completado"};function o(){!function(){const e=document.querySelector("#listado-tareas");for(;e.firstChild;)e.removeChild(e.firstChild)}(),function(){const t=e.filter(e=>"0"===e.estado),a=document.querySelector("#pendientes");0===t.length?a.disabled=!0:a.disabled=!1}(),function(){const t=e.filter(e=>"1"===e.estado),a=document.querySelector("#completadas");0===t.length?a.disabled=!0:a.disabled=!1}();const a=t.length?t:e;if(0===a.length){const e=document.querySelector("#listado-tareas"),t=document.createElement("LI");return t.textContent="No hay tareas",t.classList.add("no-tareas"),void e.appendChild(t)}a.forEach(t=>{const a=document.createElement("LI");a.dataset.tareaId=t.id,a.classList.add("tarea");const c=document.createElement("P");c.textContent=t.nombre,c.ondblclick=()=>{r({...t})};const s=document.createElement("DIV");s.classList.add("opciones");const l=document.createElement("BUTTON");l.classList.add("estado-tarea",""+n[t.estado].toLowerCase()),l.textContent=n[t.estado],l.dataset.estadoTarea=t.estado,l.ondblclick=function(){!function(e){const t="1"===e.estado?"0":"1";e.estado=t,d(e)}({...t})};const u=document.createElement("BUTTON");u.classList.add("eliminar-tarea"),u.dataset.idTarea=t.id,u.textContent="Eliminar",u.ondblclick=function(){!async function(t){Swal.fire({title:"¿Eliminar Tarea?",showCancelButton:!0,confirmButtonText:"Si"}).then(a=>{a.isConfirmed&&async function(t){const{estado:a,id:n,nombre:r}=t,c=new FormData;c.append("id",n),c.append("estado",a),c.append("nombre",r),c.append("proyectoId",i());try{const t="/api/tareas/eliminar",a=await fetch(t,{method:"POST",body:c});await a.json()&&(Swal.fire("¡Eliminado!","Eliminado Correctamente","success"),e=e.filter(e=>e.id!==n),o())}catch(e){console.log(e)}}(t)})}({...t})},s.appendChild(l),s.appendChild(u),a.appendChild(c),a.appendChild(s);document.querySelector("#listado-tareas").appendChild(a)})}function r(t=!1){const a=document.createElement("DIV");a.classList.add("modal"),a.innerHTML=`\n            <form class="formulario nueva-tarea">\n                <legend>${t?"Editar tarea":"Añade una nueva tarea"}</legend>\n                <div class="campo">\n                    <label>Tarea</label>\n                    <input \n                    type="text" \n                    name="tarea" \n                    id="tarea" \n                    placeholder="${t?"Editar Proyecto":"Añadir tarea al proyecto actual"}"\n                    value= "${t?t.nombre:""}"\n                    />\n                </div>\n                <div class="opciones">\n                    <input type="submit" class="submit-nueva-tarea" value="${t?"Actualizar Tarea":"Añadir Tarea"}" />\n                    <button type="button" class="cerrar-modal">Cancelar</button>\n                </div>\n            </form>\n        `,setTimeout(()=>{document.querySelector(".formulario").classList.add("animar")},0),a.addEventListener("click",(function(n){if(n.preventDefault(),n.target.classList.contains("cerrar-modal")){document.querySelector(".formulario").classList.add("cerrar"),setTimeout(()=>{a.remove()},500)}if(n.target.classList.contains("submit-nueva-tarea")){const a=document.querySelector("#tarea").value.trim();if(""===a){return void c("El nombre de la tarea es obligatorio","error",document.querySelector(".formulario legend"))}t?(t.nombre=a,d(t)):async function(t){const a=new FormData;a.append("nombre",t),a.append("proyectoId",i());try{const n="/api/tareas",r=await fetch(n,{method:"POST",body:a}),d=await r.json(),i=document.querySelector(".formulario legend");if(c(d.mensaje,d.tipo,i),"exito"===d.tipo){const a=document.querySelector(".modal");setTimeout(()=>{a.remove()},1500);const n={id:String(d.id),estado:"0",nombre:t,proyectoId:d.proyectoId};e=[...e,n],o()}}catch(e){console.log(e)}}(a)}})),document.querySelector(".dashboard").appendChild(a)}function c(e,t,a){const n=document.querySelector(".alertas");n&&n.remove();const o=document.createElement("DIV");o.classList.add("alertas",t),o.textContent=e,a.parentElement.insertBefore(o,a.nextElementSibling),setTimeout(()=>{o.remove()},4e3)}async function d(t){const{estado:a,id:n,nombre:r,proyectoId:c}=t,d=new FormData;d.append("id",n),d.append("estado",a),d.append("nombre",r),d.append("proyectoId",i());try{const t="/api/tareas/actualizar",c=await fetch(t,{method:"POST",body:d});if("exito"===(await c.json()).respuesta.tipo){const t=document.querySelector(".modal");t&&(Swal.fire("¡Actualizado!","Has actualizado el nombre","success"),t.remove()),e=e.map(e=>(e.id===n&&(e.estado=a,e.nombre=r),e)),o()}}catch(e){console.log(e)}}function i(){const e=new URLSearchParams(window.location.search);return Object.fromEntries(e.entries()).id}}();