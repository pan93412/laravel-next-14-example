import TocasLoading from "@/components/tocas-loading";
import classNames from "classnames";
import React from "react";

export default function TocasButton({
  disabled,
  loading,
  negative,
  children,
  ...props
}: React.ComponentPropsWithoutRef<"button"> & { loading?: boolean; negative?: boolean }) {
  return (
    <button
      className={classNames("ts-button", { "is-disabled": disabled, "is-negative": negative })}
      disabled={disabled || loading}
      {...props}
    >
      {loading ? <TocasLoading /> : children}
    </button>
  );
}
