import React, { useEffect, useState } from "react"
import axios from "axios"
import Swal from 'sweetalert2'

function App() {
	const baseAPIURI = "http://localhost:8000/api/da-test"

	const [list, setList] = useState<any>(null)
	const [count, setCount] = useState(0)

	useEffect(() => {
		getTodos()
	}, [])

	const getTodos = async () => {
		var todos = await axios.get(`${baseAPIURI}/todos`)

		setList(todos.data.data)
		setCount(todos.data.data.length)
	}

	const addTodo = async () => {
    axios.post(`${baseAPIURI}/create`, {
			description: "New Item",
		})
    .then(resp => {
        getTodos()
    })

    
  }

	const updateTodo = async (newValue: string, id: number) => {
		if(newValue.trim() === "") {
      Swal.fire({
        title: "Description is required",
        icon: "info",
        showConfirmButton: true,
        showCancelButton: false,
      })
    } else {
      await axios.patch(`${baseAPIURI}/update/${id}`, {
        description: newValue,
        status: "Active",
      })
    }
	}

	const removeTodo = async (item: any) => {
		await axios.delete(`${baseAPIURI}/remove/${item.id}`)   

    getTodos()
    
	}

	const completeTodo = async (todo: any) => {
		var newStatus = todo.status === "Active" ? "Done" : "Active"

		await axios.patch(`${baseAPIURI}/update/${todo.id}`, {
			description: todo.description,
			status: newStatus,
		})

    getTodos()
	}

	return (
		<>
			<main className="container w-[1140px] mx-auto">
				<div className="py-8">
					<h3 className="text-center">TO DO LIST</h3>
				</div>

				<div className="p-[20px] rounded border border-stone-400">
					<button className="px-6 py-2 mx-2 bg-zinc-800 rounded-md text-white mb-[10px]" onClick={addTodo}>
						<svg className="w-4 h-4 text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 18 18">
							<path stroke="currentColor" strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M9 1v16M1 9h16" />
						</svg>
					</button>

					<ul className="w-1140 text-sm font-medium text-gray-900 bg-white border border-gray-200 rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-white">
						{list &&
							list.map((item: any) => (
								<li key={item.id} className="m-2 flex flex-row">
									{item.status === "Active" ? (
										<input
											type="text"
											className="border-gray-100 text-gray-900 text-md rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 "
											defaultValue={item.description}
											onChange={(e: any) => updateTodo(e.currentTarget.value, item.id)}
										/>
									) : (
										<input
											type="text"
											className="border-gray-100 text-emerald-900 text-md rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 line-through"
											defaultValue={item.description}
											readOnly
										/>
									)}

									<button className="p-3 mx-2 bg-emerald-500 rounded-md text-white" onClick={(e: any) => completeTodo(item)}>
										Done
									</button>
									<button className="p-3 mx-2 bg-zinc-800 text-white rounded-md" onClick={(e: any) => removeTodo(item)}>
										Delete
									</button>
								</li>
							))}
					</ul>
				</div>
			</main>
		</>
	)
}

export default App
