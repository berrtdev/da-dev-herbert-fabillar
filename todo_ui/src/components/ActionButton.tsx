
function ActionButton({name, clickHandler, icon} : {name: string, clickHandler?: any, icon?: any}) {
    return(
        <>
            {
                icon != null ?
                <button 
                    onClick={clickHandler}
                    className="bg-zinc-800 rounded-lg hover:bg-zinc-900 shadow-md text-white px-4 py-1 text-sm flex flex-row justify-center items-center">
                    {icon} &nbsp; {name}
                </button>
                : 
                <button 
                    onClick={clickHandler}
                    className="bg-zinc-800 rounded-lg hover:bg-zinc-900 shadow-md text-white px-4 py-1 text-sm">
                    {name}
                </button>
            }
        </>
    )
}

export default ActionButton