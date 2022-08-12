import * as React from "react";

function IconDotsDiagonal({
  size = 24,
  color = "currentColor",
  stroke = 2,
  ...props
}) {
  return <svg className="icon icon-tabler icon-tabler-dots-diagonal" width={size} height={size} viewBox="0 0 24 24" strokeWidth={stroke} stroke={color} fill="none" strokeLinecap="round" strokeLinejoin="round" {...props}><path stroke="none" d="M0 0h24v24H0z" fill="none" /><circle cx={7} cy={17} r={1} /><circle cx={12} cy={12} r={1} /><circle cx={17} cy={7} r={1} /></svg>;
}

export default IconDotsDiagonal;